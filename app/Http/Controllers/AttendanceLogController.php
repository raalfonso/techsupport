<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceLogController extends Controller
{
    public function dashboard()
    {
        $isAdmin = auth()->user()->authAssignments()->where('item_name', 'Administrator')->exists();
        $canViewAll = $isAdmin || auth()->user()->authAssignments()->whereIn('item_name', ['HR_admin', 'depthead'])->exists();

        $logsQuery = AttendanceLog::with('user.masterlist.department')->latest();
        if (!$canViewAll) {
            $logsQuery->where('user_id', auth()->id());
        }
        $logs = $logsQuery->paginate(10, ['*'], 'logs_page');

        // Accomplishments with date range filtering
        $accomplishmentsQuery = \App\Models\WFHAccomplishment::where('employee_id', auth()->id())
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');

        $accStartDate = request('acc_start_date');
        $accEndDate = request('acc_end_date');

        if ($accStartDate && $accEndDate) {
            $accomplishmentsQuery->whereBetween('date', [$accStartDate, $accEndDate]);
        } elseif ($accStartDate) {
            $accomplishmentsQuery->whereDate('date', '>=', $accStartDate);
        } elseif ($accEndDate) {
            $accomplishmentsQuery->whereDate('date', '<=', $accEndDate);
        }

        $accomplishments = $accomplishmentsQuery->paginate(10, ['*'], 'acc_page');

        // Pass filters to view
        $filters = [
            'name' => request('name'),
            'department' => request('department'),
            'employment_type' => request('employment_type'),
            'start_date' => request('start_date'),
            'end_date' => request('end_date')
        ];

        return view('attendance_logs.dashboard', compact('logs', 'accomplishments', 'isAdmin', 'canViewAll', 'filters'));
    }

    public function clockIn()
    {
        // Prevent duplicate clock-in for the same day
        $alreadyClockedIn = AttendanceLog::where('user_id', auth()->id())
            ->whereDate('date', today())
            ->where('mode', 'Attend')
            ->exists();

        if ($alreadyClockedIn) {
            return redirect()->route('attendance.dashboard')->with('error', 'You have already clocked in today.');
        }

        try {
            AttendanceLog::create([
                'date' => today(),
                'time' => now()->format('H:i:s'),
                'user_id' => auth()->id(),
                'name' => auth()->user()->name,
                'employee_id' => auth()->user()->email,
                'terminal_id' => 'online',
                'class' => 'User',
                'mode' => 'Attend',
            ]);

            return redirect()->route('attendance.dashboard')->with('success', 'Clocked in successfully at ' . now()->format('H:i:s'));
        } catch (\Exception $e) {
            return redirect()->route('attendance.dashboard')->with('error', 'Failed to clock in: ' . $e->getMessage());
        }
    }

    public function clockOut()
    {
        try {
            $attendanceLog = AttendanceLog::create([
                'date' => today(),
                'time' => now()->format('H:i:s'),
                'user_id' => auth()->id(),
                'name' => auth()->user()->name,
                'employee_id' => auth()->user()->email,
                'terminal_id' => 'online',
                'class' => 'User',
                'mode' => 'Leave',
            ]);

            // Save WFH accomplishments if provided
            $accomplishments = request()->input('accomplishment');
            $additionalAccomplishments = request()->input('accomplishments', []);
            
            $user = auth()->user();
            $departmentId = $user->masterlist?->department_id ?? null;

            // Save main accomplishment
            if (!empty($accomplishments)) {
                \App\Models\WFHAccomplishment::create([
                    'employee_id' => auth()->id(),
                    'department_id' => $departmentId,
                    'accomplishment' => $accomplishments,
                    'date' => today(),
                ]);
            }

            // Save additional accomplishments
            foreach ($additionalAccomplishments as $accomplishment) {
                if (!empty($accomplishment)) {
                    \App\Models\WFHAccomplishment::create([
                        'employee_id' => auth()->id(),
                        'department_id' => $departmentId,
                        'accomplishment' => $accomplishment,
                        'date' => today(),
                    ]);
                }
            }

            return redirect()->route('attendance.dashboard')->with('success', 'Clocked out successfully at ' . now()->format('H:i:s'));
        } catch (\Exception $e) {
            return redirect()->route('attendance.dashboard')->with('error', 'Failed to clock out: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $logs = AttendanceLog::with('user')->latest()->paginate(20);
        return view('attendance_logs.index', compact('logs'));
    }

    public function create()
    {
        $users = User::all();
        return view('attendance_logs.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'employee_id' => 'required|string',
            'mode' => 'required|in:Attend,Leave',
            'coordinate' => 'nullable|string'
        ]);

        $validated['terminal_id'] = $request->terminal_id ?? 'online';
        $validated['class'] = $request->class ?? 'User';

        AttendanceLog::create($validated);

        return redirect()->route('attendance-logs.index')->with('success', 'Attendance log created successfully');
    }

    public function show(AttendanceLog $attendanceLog)
    {
        return view('attendance_logs.show', compact('attendanceLog'));
    }

    public function edit(AttendanceLog $attendanceLog)
    {
        $users = User::all();
        return view('attendance_logs.edit', compact('attendanceLog', 'users'));
    }

    public function update(Request $request, AttendanceLog $attendanceLog)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'employee_id' => 'required|string',
            'mode' => 'required|in:Attend,Leave',
            'coordinate' => 'nullable|string'
        ]);

        $attendanceLog->update($validated);

        return redirect()->route('attendance-logs.index')->with('success', 'Attendance log updated successfully');
    }

    public function destroy(AttendanceLog $attendanceLog)
    {
        $attendanceLog->delete();
        return redirect()->route('attendance-logs.index')->with('success', 'Attendance log deleted successfully');
    }

    public function search(Request $request)
    {
        $isAdmin = auth()->user()->authAssignments()->where('item_name', 'Administrator')->exists();
        $canViewAll = $isAdmin || auth()->user()->authAssignments()->whereIn('item_name', ['HR_admin', 'depthead'])->exists();
        $name = $request->input('name');
        $department = $request->input('department');
        $employmentType = $request->input('employment_type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = AttendanceLog::with('user.masterlist.department')->latest();

        if (!$canViewAll) {
            $query->where('user_id', auth()->id());
        }

        if ($name) {
            $query->whereHas('user', function ($q) use ($name) {
                $q->where('name', 'like', '%' . $name . '%');
            });
        }

        if ($department) {
            $query->whereHas('user.masterlist.department', function ($q) use ($department) {
                $q->where('title', 'like', '%' . $department . '%');
            });
        }

        if ($employmentType) {
            $query->whereHas('user.masterlist', function ($q) use ($employmentType) {
                $q->where('employment_type', $employmentType);
            });
        }

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        $logs = $query->paginate(10, ['*'], 'logs_page');

        // Accomplishments with date range filtering
        $accomplishmentsQuery = \App\Models\WFHAccomplishment::where('employee_id', auth()->id())
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');

        $accStartDate = $request->input('acc_start_date');
        $accEndDate = $request->input('acc_end_date');

        if ($accStartDate && $accEndDate) {
            $accomplishmentsQuery->whereBetween('date', [$accStartDate, $accEndDate]);
        } elseif ($accStartDate) {
            $accomplishmentsQuery->whereDate('date', '>=', $accStartDate);
        } elseif ($accEndDate) {
            $accomplishmentsQuery->whereDate('date', '<=', $accEndDate);
        }

        $accomplishments = $accomplishmentsQuery->paginate(10, ['*'], 'acc_page');

        return view('attendance_logs.dashboard', [
            'logs' => $logs,
            'accomplishments' => $accomplishments,
            'isAdmin' => $isAdmin,
            'canViewAll' => $canViewAll,
            'filters' => [
                'name' => $name,
                'department' => $department,
                'employment_type' => $employmentType,
                'start_date' => $startDate,
                'end_date' => $endDate
            ]
        ]);
    }

    public function getEmployees(Request $request)
    {
        $search = $request->input('search', '');
        $employees = User::with('masterlist')
            ->where('name', 'like', '%' . $search . '%')
            ->limit(10)
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'employee_id' => $user->masterlist->employee_number ?? 'N/A'
                ];
            });
        
        return response()->json($employees);
    }

    public function getDepartments(Request $request)
    {
        $search = $request->input('search', '');
        $departments = \App\Models\Department::where('title', 'like', '%' . $search . '%')
            ->where('active', 1)
            ->limit(10)
            ->get(['id', 'title as name']);
        
        return response()->json($departments);
    }

    public function presentToday()
    {
        $user = auth()->user();
        $isAdmin = $user->authAssignments()->where('item_name', 'Administrator')->exists();
        $isHRAdmin = $user->authAssignments()->where('item_name', 'HR_admin')->exists();
        $isDeptHead = $user->authAssignments()->where('item_name', 'depthead')->exists();

        if (!$isAdmin && !$isHRAdmin && !$isDeptHead) {
            return redirect()->route('attendance.dashboard')->with('error', 'Unauthorized access');
        }

        $query = AttendanceLog::where('mode', 'Attend')
            ->whereDate('date', today())
            ->with('user.masterlist.department');

        // depthead only sees their own department
        if ($isDeptHead && !$isAdmin && !$isHRAdmin) {
            $deptId = $user->masterlist?->department_id;
            $query->whereHas('user.masterlist', fn($q) => $q->where('department_id', $deptId));
        }

        $presentEmployees = $query->distinct('user_id')->get();

        return view('attendance_logs.present-today', compact('presentEmployees'));
    }

    public function reports(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->authAssignments()->where('item_name', 'Administrator')->exists();
        $isHRAdmin = $user->authAssignments()->where('item_name', 'HR_admin')->exists();
        $isDeptHead = $user->authAssignments()->where('item_name', 'depthead')->exists();

        if (!$isAdmin && !$isHRAdmin && !$isDeptHead) {
            return redirect()->route('attendance.dashboard')->with('error', 'Unauthorized access');
        }

        // Get attendance date filter (default to today)
        $attendanceDate = $request->input('attendance_date', today()->toDateString());

        // For depthead, scope everything to their department
        $deptHeadDeptId = ($isDeptHead && !$isAdmin && !$isHRAdmin)
            ? $user->masterlist?->department_id
            : null;
        $deptHeadDeptTitle = $deptHeadDeptId
            ? \App\Models\Department::find($deptHeadDeptId)?->title
            : null;

        // Stats — based on employee_masterlist (Active employees only with matching user accounts via email)
        $totalEmployeesQuery = \App\Models\EmployeeMasterlist::where('employment_status', 'Active')
            ->whereHas('user'); // Only count employees with linked user accounts via email
        
        if ($deptHeadDeptId) {
            $totalEmployeesQuery->where('department_id', $deptHeadDeptId);
        }

        $totalEmployees = $totalEmployeesQuery->count();

        // Present for selected date - employees who clocked in
        $presentTodayQuery = AttendanceLog::where('mode', 'Attend')
            ->whereDate('date', $attendanceDate)
            ->with('user.masterlist');

        if ($deptHeadDeptId) {
            $presentTodayQuery->whereHas('user.masterlist', fn($q) => $q->where('department_id', $deptHeadDeptId)->where('employment_status', 'Active'));
        } else {
            $presentTodayQuery->whereHas('user.masterlist', fn($q) => $q->where('employment_status', 'Active'));
        }

        $presentToday = $presentTodayQuery->distinct('user_id')->count();
        $absentToday = $totalEmployees - $presentToday;

        // Attendance by department for selected date
        $attendanceByDeptQuery = AttendanceLog::where('mode', 'Attend')
            ->whereDate('date', $attendanceDate)
            ->with('user.masterlist.department')
            ->whereHas('user.masterlist', fn($q) => $q->where('employment_status', 'Active'));

        if ($deptHeadDeptId) {
            $attendanceByDeptQuery->whereHas('user.masterlist', fn($q) => $q->where('department_id', $deptHeadDeptId));
        }

        $presentByDepartment = $attendanceByDeptQuery->get()
            ->groupBy('user.masterlist.department.title')
            ->map(fn($logs) => $logs->unique('user_id')->count());

        // Get total employees per department
        $totalByDeptQuery = \App\Models\EmployeeMasterlist::where('employment_status', 'Active')
            ->with('department')
            ->whereHas('user');

        if ($deptHeadDeptId) {
            $totalByDeptQuery->where('department_id', $deptHeadDeptId);
        }

        $totalByDepartment = $totalByDeptQuery->get()
            ->groupBy('department.title')
            ->map(fn($employees) => $employees->count());

        // Calculate attendance by department with percentage
        $attendanceByDepartment = [];
        foreach ($presentByDepartment as $dept => $presentCount) {
            $totalCount = $totalByDepartment[$dept] ?? 0;
            $percentage = $totalCount > 0 ? round(($presentCount / $totalCount) * 100, 1) : 0;
            $attendanceByDepartment[$dept] = [
                'present' => $presentCount,
                'total' => $totalCount,
                'percentage' => $percentage
            ];
        }

        // WFH filters — depthead locked to their dept
        $wfhDate       = $request->input('wfh_date', today()->toDateString());
        $wfhDepartment = $deptHeadDeptTitle ?? $request->input('wfh_department', '');

        $accomplishmentsQuery = \App\Models\WFHAccomplishment::with('user.masterlist', 'department')
            ->whereDate('date', $wfhDate);

        if ($wfhDepartment) {
            $accomplishmentsQuery->whereHas('department', function ($q) use ($wfhDepartment) {
                $q->where('title', $wfhDepartment);
            });
        }

        $accomplishmentsRaw = $accomplishmentsQuery->orderBy('date', 'desc')->get();

        $wfhAccomplishments = [];
        foreach ($accomplishmentsRaw as $acc) {
            $key = $acc->employee_id . '_' . $acc->date->format('Y-m-d');
            if (!isset($wfhAccomplishments[$key])) {
                $wfhAccomplishments[$key] = [
                    'employee_name'  => $acc->user->name ?? 'N/A',
                    'employee_id'    => $acc->user->masterlist->employee_number ?? 'N/A',
                    'department'     => $acc->department->title ?? 'Unassigned',
                    'date'           => $acc->date->format('M d, Y'),
                    'accomplishments' => [],
                ];
            }
            $wfhAccomplishments[$key]['accomplishments'][] = $acc->accomplishment;
        }

        $departments = \App\Models\Department::orderBy('title')->pluck('title');

        // Get present employees list for selected date (Active employees only)
        $presentEmployeesQuery = AttendanceLog::where('mode', 'Attend')
            ->whereDate('date', $attendanceDate)
            ->with('user.masterlist.department')
            ->whereHas('user.masterlist', fn($q) => $q->where('employment_status', 'Active'))
            ->distinct('user_id');

        if ($deptHeadDeptId) {
            $presentEmployeesQuery->whereHas('user.masterlist', fn($q) => $q->where('department_id', $deptHeadDeptId));
        }

        $presentEmployees = $presentEmployeesQuery->get()->map(function($log) {
            return [
                'name' => $log->user->name ?? 'N/A',
                'employee_number' => $log->user->masterlist->employee_number ?? 'N/A',
                'department' => $log->user->masterlist->department->title ?? 'Unassigned',
                'time' => $log->time
            ];
        });

        // Get absent employees list for selected date (Active employees without time-in)
        $allEmployeesQuery = \App\Models\EmployeeMasterlist::where('employment_status', 'Active')
            ->with(['department', 'user'])
            ->whereHas('user'); // Only get employees with linked user accounts via email

        if ($deptHeadDeptId) {
            $allEmployeesQuery->where('department_id', $deptHeadDeptId);
        }

        $allEmployees = $allEmployeesQuery->get();
        
        // Get user IDs of present employees for selected date
        $presentUserIds = AttendanceLog::where('mode', 'Attend')
            ->whereDate('date', $attendanceDate)
            ->whereHas('user.masterlist', fn($q) => $q->where('employment_status', 'Active'))
            ->pluck('user_id')
            ->unique();

        // Filter absent employees - those who have user accounts but didn't clock in on selected date
        $absentEmployees = $allEmployees->filter(function($employee) use ($presentUserIds) {
            return $employee->user && !$presentUserIds->contains($employee->user->id);
        })->map(function($employee) {
            return [
                'name' => $employee->full_name,
                'employee_number' => $employee->employee_number,
                'department' => $employee->department->title ?? 'Unassigned',
                'position' => $employee->position
            ];
        })->values();

       

        return view('attendance_logs.reports', compact('totalEmployees', 'presentToday', 'absentToday','absentEmployees', 'attendanceByDepartment', 'wfhAccomplishments', 'wfhDate', 'wfhDepartment', 'departments', 'deptHeadDeptTitle', 'presentEmployees', 'attendanceDate'));
    }

    public function statistics(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->authAssignments()->where('item_name', 'Administrator')->exists();
        $isHRAdmin = $user->authAssignments()->where('item_name', 'HR_admin')->exists();
        $isDeptHead = $user->authAssignments()->where('item_name', 'depthead')->exists();

        if (!$isAdmin && !$isHRAdmin && !$isDeptHead) {
            return redirect()->route('attendance.dashboard')->with('error', 'Unauthorized access');
        }

        // Date range filters
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // For depthead, scope to their department
        $deptHeadDeptId = ($isDeptHead && !$isAdmin && !$isHRAdmin)
            ? $user->masterlist?->department_id
            : null;

        // Total employees
        $totalEmployeesQuery = \App\Models\EmployeeMasterlist::where('employment_status', 'Active');
        if ($deptHeadDeptId) {
            $totalEmployeesQuery->where('department_id', $deptHeadDeptId);
        }
        $totalEmployees = $totalEmployeesQuery->count();

        // Attendance statistics for date range
        $attendanceQuery = AttendanceLog::whereBetween('date', [$startDate, $endDate]);
        if ($deptHeadDeptId) {
            $attendanceQuery->whereHas('user.masterlist', fn($q) => $q->where('department_id', $deptHeadDeptId));
        }

        $totalAttendance = $attendanceQuery->where('mode', 'Attend')->distinct('user_id', 'date')->count();
        $totalLeave = $attendanceQuery->where('mode', 'Leave')->distinct('user_id', 'date')->count();

        // Average attendance per day
        $daysInRange = \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1;
        $avgAttendancePerDay = $daysInRange > 0 ? round($totalAttendance / $daysInRange, 2) : 0;

        // Attendance by department
        $attendanceByDept = AttendanceLog::whereBetween('date', [$startDate, $endDate])
            ->where('mode', 'Attend')
            ->with('user.masterlist.department')
            ->get()
            ->groupBy('user.masterlist.department.title')
            ->map(fn($logs) => $logs->unique(fn($log) => $log->user_id . '_' . $log->date->format('Y-m-d'))->count())
            ->sortDesc();

        // Attendance by employment type
        $attendanceByType = AttendanceLog::whereBetween('date', [$startDate, $endDate])
            ->where('mode', 'Attend')
            ->with('user.masterlist')
            ->get()
            ->groupBy('user.masterlist.employment_type')
            ->map(fn($logs) => $logs->unique(fn($log) => $log->user_id . '_' . $log->date->format('Y-m-d'))->count())
            ->sortDesc();

        // Daily attendance trend
        $dailyAttendance = AttendanceLog::whereBetween('date', [$startDate, $endDate])
            ->where('mode', 'Attend')
            ->selectRaw('DATE(date) as attendance_date, COUNT(DISTINCT user_id) as count')
            ->groupBy('attendance_date')
            ->orderBy('attendance_date')
            ->get()
            ->pluck('count', 'attendance_date');

        // Top 10 most punctual employees (earliest clock-in)
        $punctualEmployees = AttendanceLog::whereBetween('date', [$startDate, $endDate])
            ->where('mode', 'Attend')
            ->with('user.masterlist')
            ->selectRaw('user_id, AVG(TIME_TO_SEC(time)) as avg_time')
            ->groupBy('user_id')
            ->orderBy('avg_time', 'asc')
            ->limit(10)
            ->get()
            ->map(function($log) {
                return [
                    'name' => $log->user->name ?? 'N/A',
                    'avg_time' => gmdate('H:i:s', $log->avg_time)
                ];
            });

        // Late arrivals (after 9:00 AM)
        $lateArrivals = AttendanceLog::whereBetween('date', [$startDate, $endDate])
            ->where('mode', 'Attend')
            ->whereTime('time', '>', '09:00:00')
            ->distinct('user_id', 'date')
            ->count();

        $departments = \App\Models\Department::where('active', 1)->orderBy('title')->get();

        return view('attendance_logs.statistics.index', compact(
            'totalEmployees',
            'totalAttendance',
            'totalLeave',
            'avgAttendancePerDay',
            'attendanceByDept',
            'attendanceByType',
            'dailyAttendance',
            'punctualEmployees',
            'lateArrivals',
            'startDate',
            'endDate',
            'departments',
            'daysInRange'
        ));
    }

    public function exportWFHPdf(Request $request)
        {
            $isAdmin = auth()->user()->authAssignments()->where('item_name', 'Administrator')->exists();
            $isHrAdmin = auth()->user()->authAssignments()->where('item_name', 'HR_admin')->exists();
           if (!$isAdmin && !$isHrAdmin) {
                return redirect()->route('attendance.dashboard')->with('error', 'Unauthorized access');
            }

            $wfhDate = $request->input('wfh_date', today()->toDateString());
            $wfhDepartment = $request->input('wfh_department', '');

            $accomplishmentsQuery = \App\Models\WFHAccomplishment::with('user.masterlist', 'department')
                ->whereDate('date', $wfhDate);

            if ($wfhDepartment) {
                $accomplishmentsQuery->whereHas('department', function ($q) use ($wfhDepartment) {
                    $q->where('title', $wfhDepartment);
                });
            }

            $accomplishmentsRaw = $accomplishmentsQuery->orderBy('date', 'desc')->get();

            $wfhAccomplishments = [];
            foreach ($accomplishmentsRaw as $acc) {
                $key = $acc->employee_id . '_' . $acc->date->format('Y-m-d');
                if (!isset($wfhAccomplishments[$key])) {
                    $wfhAccomplishments[$key] = [
                        'employee_name'  => $acc->user->name ?? 'N/A',
                        'employee_id'    => $acc->user->masterlist->employee_number ?? 'N/A',
                        'department'     => $acc->department->title ?? 'Unassigned',
                        'date'           => $acc->date->format('M d, Y'),
                        'accomplishments' => [],
                    ];
                }
                $wfhAccomplishments[$key]['accomplishments'][] = $acc->accomplishment;
            }

            $wfhAccomplishments = array_values($wfhAccomplishments);

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('attendance_logs.wfh_accomplishments_pdf', compact('wfhAccomplishments', 'wfhDate', 'wfhDepartment'));
            $pdf->setPaper('a4', 'portrait');

            return $pdf->stream("wfh_accomplishments_{$wfhDate}.pdf");
        }
    public function printAttendancePdf(Request $request)
        {
            $isAdmin = auth()->user()->authAssignments()->where('item_name', 'Administrator')->exists();
            $canViewAll = $isAdmin || auth()->user()->authAssignments()->whereIn('item_name', ['HR_admin', 'depthead'])->exists();

            $name           = $request->input('name');
            $department     = $request->input('department');
            $employmentType = $request->input('employment_type');
            $startDate      = $request->input('start_date');
            $endDate        = $request->input('end_date');

            $query = AttendanceLog::with('user.masterlist.department')->latest();

            if (!$canViewAll) {
                $query->where('user_id', auth()->id());
            }

            if ($name) {
                $query->whereHas('user', fn($q) => $q->where('name', 'like', "%$name%"));
            }
            if ($department) {
                $query->whereHas('user.masterlist.department', fn($q) => $q->where('title', 'like', "%$department%"));
            }
            if ($employmentType) {
                $query->whereHas('user.masterlist', fn($q) => $q->where('employment_type', $employmentType));
            }
            if ($startDate && $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            } elseif ($startDate) {
                $query->whereDate('date', '>=', $startDate);
            } elseif ($endDate) {
                $query->whereDate('date', '<=', $endDate);
            }

            $rawLogs = $query->get();

            // Group by user+date to pair Time In / Time Out
            $grouped = [];
            foreach ($rawLogs as $log) {
                $key = $log->user_id . '_' . $log->date->format('Y-m-d');
                if (!isset($grouped[$key])) {
                    $grouped[$key] = [
                        'date'          => $log->date->format('M d, Y'),
                        'employee_name' => $log->user->name ?? 'N/A',
                        'time_in'       => null,
                        'time_out'      => null,
                    ];
                }
                if ($log->mode === 'Attend') {
                    $grouped[$key]['time_in'] = date('g:i A', strtotime($log->time));
                } elseif ($log->mode === 'Leave') {
                    $grouped[$key]['time_out'] = date('g:i A', strtotime($log->time));
                }
            }

            $records = array_values($grouped);

            // Get signatories based on department
            $user = auth()->user();
            
            // For administrators, use department search filter if provided
            // For regular users, use their own department_id
            if ($isAdmin && $department) {
                $signatories = \App\Models\Signatory::with('employee', 'department')
                    ->whereHas('department', function ($q) use ($department) {
                        $q->where('title', 'like', "%$department%");
                    })
                    ->get();
            } else {
                $userDepartmentId = $user->masterlist?->department_id;
                $signatories = \App\Models\Signatory::with('employee', 'department')
                    ->when($userDepartmentId, function ($q) use ($userDepartmentId) {
                        $q->where('department_id', $userDepartmentId);
                    })
                    ->get();
            }

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('attendance_logs.attendance_print_pdf', compact('records', 'signatories'));
            $pdf->setPaper('a4', 'portrait');

            return $pdf->stream('attendance_report.pdf');
        }

    public function printPresentTodayPdf(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->authAssignments()->where('item_name', 'Administrator')->exists();
        $isHRAdmin = $user->authAssignments()->where('item_name', 'HR_admin')->exists();
        $isDeptHead = $user->authAssignments()->where('item_name', 'depthead')->exists();

        if (!$isAdmin && !$isHRAdmin && !$isDeptHead) {
            return redirect()->route('attendance.dashboard')->with('error', 'Unauthorized access');
        }

        // Get date from request or default to today
        $date = $request->input('date', today()->toDateString());

        // For depthead, scope to their department
        $deptHeadDeptId = ($isDeptHead && !$isAdmin && !$isHRAdmin)
            ? $user->masterlist?->department_id
            : null;

        // Get present employees list (Active employees only) for the selected date
        $presentEmployeesQuery = AttendanceLog::where('mode', 'Attend')
            ->whereDate('date', $date)
            ->with('user.masterlist.department')
            ->whereHas('user.masterlist', fn($q) => $q->where('employment_status', 'Active'))
            ->distinct('user_id');

        if ($deptHeadDeptId) {
            $presentEmployeesQuery->whereHas('user.masterlist', fn($q) => $q->where('department_id', $deptHeadDeptId));
        }

        $presentEmployees = $presentEmployeesQuery->get()->map(function($log) {
            return [
                'name' => $log->user->name ?? 'N/A',
                'employee_number' => $log->user->masterlist->employee_number ?? 'N/A',
                'department' => $log->user->masterlist->department->title ?? 'Unassigned',
                'time' => $log->time
            ];
        });

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('attendance_logs.present_today_pdf', compact('presentEmployees', 'date'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('present_' . $date . '.pdf');
    }

    public function printAbsentTodayPdf(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->authAssignments()->where('item_name', 'Administrator')->exists();
        $isHRAdmin = $user->authAssignments()->where('item_name', 'HR_admin')->exists();
        $isDeptHead = $user->authAssignments()->where('item_name', 'depthead')->exists();

        if (!$isAdmin && !$isHRAdmin && !$isDeptHead) {
            return redirect()->route('attendance.dashboard')->with('error', 'Unauthorized access');
        }

        // Get date from request or default to today
        $date = $request->input('date', today()->toDateString());

        // For depthead, scope to their department
        $deptHeadDeptId = ($isDeptHead && !$isAdmin && !$isHRAdmin)
            ? $user->masterlist?->department_id
            : null;

        // Total employees
        $totalEmployeesQuery = \App\Models\EmployeeMasterlist::where('employment_status', 'Active')
            ->with(['department', 'user'])
            ->whereHas('user');

        if ($deptHeadDeptId) {
            $totalEmployeesQuery->where('department_id', $deptHeadDeptId);
        }

        $allEmployees = $totalEmployeesQuery->get();
        
        // Get user IDs of present employees for the selected date
        $presentUserIds = AttendanceLog::where('mode', 'Attend')
            ->whereDate('date', $date)
            ->whereHas('user.masterlist', fn($q) => $q->where('employment_status', 'Active'))
            ->pluck('user_id')
            ->unique();

        // Filter absent employees - those who have user accounts but didn't clock in on selected date
        $absentEmployees = $allEmployees->filter(function($employee) use ($presentUserIds) {
            return $employee->user && !$presentUserIds->contains($employee->user->id);
        })->map(function($employee) {
            return [
                'name' => $employee->full_name,
                'employee_number' => $employee->employee_number,
                'department' => $employee->department->title ?? 'Unassigned',
                'position' => $employee->position
            ];
        })->values();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('attendance_logs.absent_today_pdf', compact('absentEmployees', 'date'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('absent_' . $date . '.pdf');
    }

    public function storeAccomplishment()
    {
        try {
            $user = auth()->user();
            $departmentId = $user->masterlist?->department_id ?? null;

            // Save main accomplishment
            $accomplishment = request()->input('accomplishment');
            if (!empty($accomplishment)) {
                \App\Models\WFHAccomplishment::create([
                    'employee_id' => auth()->id(),
                    'department_id' => $departmentId,
                    'accomplishment' => $accomplishment,
                    'date' => today(),
                ]);
            }

            // Save additional accomplishments
            $additionalAccomplishments = request()->input('accomplishments', []);
            foreach ($additionalAccomplishments as $acc) {
                if (!empty($acc)) {
                    \App\Models\WFHAccomplishment::create([
                        'employee_id' => auth()->id(),
                        'department_id' => $departmentId,
                        'accomplishment' => $acc,
                        'date' => today(),
                    ]);
                }
            }

            return redirect()->route('attendance.dashboard')->with('success', 'Accomplishment saved successfully!');
        } catch (\Exception $e) {
            return redirect()->route('attendance.dashboard')->with('error', 'Failed to save accomplishment: ' . $e->getMessage());
        }
    }

    public function exportCSV(Request $request)
    {
        $isAdmin = auth()->user()->authAssignments()->where('item_name', 'Administrator')->exists();
        $canViewAll = $isAdmin || auth()->user()->authAssignments()->whereIn('item_name', ['HR_admin', 'depthead'])->exists();

        $name = $request->input('name');
        $department = $request->input('department');
        $employmentType = $request->input('employment_type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = AttendanceLog::with('user.masterlist')->latest();

        if (!$canViewAll) {
            $query->where('user_id', auth()->id());
        }

        if ($name) {
            $query->whereHas('user', function ($q) use ($name) {
                $q->where('name', 'like', '%' . $name . '%');
            });
        }

        if ($department) {
            $query->whereHas('user.masterlist.department', function ($q) use ($department) {
                $q->where('title', 'like', '%' . $department . '%');
            });
        }

        if ($employmentType) {
            $query->whereHas('user.masterlist', function ($q) use ($employmentType) {
                $q->where('employment_type', $employmentType);
            });
        }

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        $logs = $query->get();
        $user = auth()->user();

        // Generate CSV
        $filename = 'attendance_' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($logs, $isAdmin, $canViewAll, $user) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            if ($canViewAll) {
                fputcsv($file, ['Date', 'Time', 'Employee Name', 'Employee ID', 'Class', 'Mode', 'Type', 'Card Serial', 'Result', 'Property', 'External Device', 'Coordinate']);
            } else {
                fputcsv($file, ['Date', 'Time', 'User ID', 'Name', 'Employee ID', 'Class', 'Mode', 'Type', 'Card Serial', 'Result', 'Property', 'External Device', 'Coordinate']);
            }

            // CSV Data
            foreach ($logs as $log) {
                $date = $log->date->format('Y-m-d');
                $time = $log->time;
                $employeeId = $log->user->masterlist->employee_number ?? '';
                $className = 'User';
                $mode = $log->mode;
                $type = $log->mode;
                $cardSerial = '';
                $result = 'success';
                $property = '1000';
                $externalDevice = 'ClockWize';
                $coordinate = '0/0';

                if ($canViewAll) {
                    $employeeName = $log->user->name ?? 'N/A';
                    fputcsv($file, [$date, $time, $employeeName, $employeeId, $className, $mode, $type, $cardSerial, $result, $property, $externalDevice, $coordinate]);
                } else {
                    $userId = $user->id;
                    $name = $user->name;
                    fputcsv($file, [$date, $time, $userId, $name, $employeeId, $className, $mode, $type, $cardSerial, $result, $property, $externalDevice, $coordinate]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function printAccomplishments(Request $request)
    {
        $user = auth()->user();
        $accStartDate = $request->input('acc_start_date');
        $accEndDate = $request->input('acc_end_date');

        $query = \App\Models\WFHAccomplishment::where('employee_id', $user->id)
            ->with('user.masterlist')
            ->orderBy('date', 'desc');

        if ($accStartDate && $accEndDate) {
            $query->whereBetween('date', [$accStartDate, $accEndDate]);
        } elseif ($accStartDate) {
            $query->whereDate('date', '>=', $accStartDate);
        } elseif ($accEndDate) {
            $query->whereDate('date', '<=', $accEndDate);
        }

        $accomplishments = $query->get();

        // Get attendance logs for time in/out
        $attendanceQuery = \App\Models\AttendanceLog::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'asc');

        if ($accStartDate && $accEndDate) {
            $attendanceQuery->whereBetween('date', [$accStartDate, $accEndDate]);
        } elseif ($accStartDate) {
            $attendanceQuery->whereDate('date', '>=', $accStartDate);
        } elseif ($accEndDate) {
            $attendanceQuery->whereDate('date', '<=', $accEndDate);
        }

        $attendanceLogs = $attendanceQuery->get();

        // Group attendance by date
        $attendanceByDate = [];
        foreach ($attendanceLogs as $log) {
            $dateKey = $log->date->format('Y-m-d');
            if (!isset($attendanceByDate[$dateKey])) {
                $attendanceByDate[$dateKey] = [
                    'time_in' => null,
                    'time_out' => null
                ];
            }
            // First entry is time in, last entry is time out
            if ($attendanceByDate[$dateKey]['time_in'] === null) {
                $attendanceByDate[$dateKey]['time_in'] = $log->time;
            }
            $attendanceByDate[$dateKey]['time_out'] = $log->time;
        }

        // Group by date
        $grouped = [];
        foreach ($accomplishments as $acc) {
            $dateKey = $acc->date->format('Y-m-d');
            if (!isset($grouped[$dateKey])) {
                $grouped[$dateKey] = [
                    'date' => $acc->date->format('F d, Y'),
                    'items' => [],
                    'time_in' => $attendanceByDate[$dateKey]['time_in'] ?? null,
                    'time_out' => $attendanceByDate[$dateKey]['time_out'] ?? null
                ];
            }
            $grouped[$dateKey]['items'][] = $acc->accomplishment;
        }

        $employeeName = $user->name;
        $employeeNumber = $user->masterlist->employee_number ?? 'N/A';
        $department = $user->masterlist->department->title ?? 'N/A';
        $departmentId = $user->masterlist->department_id ?? null;
        $position = $user->masterlist->position ?? 'N/A';

        // Get signatories for the user's department
        $signatories = \App\Models\Signatory::with('employee', 'department')
            ->when($departmentId, function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            })
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('attendance_logs.accomplishments_print_pdf', compact('grouped', 'employeeName', 'employeeNumber', 'department', 'position', 'signatories', 'accStartDate', 'accEndDate'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('accomplishments_' . $user->id . '_' . now()->format('Y-m-d') . '.pdf');
    }
}
