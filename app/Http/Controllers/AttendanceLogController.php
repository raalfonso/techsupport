<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceLogController extends Controller
{
    public function dashboard()
    {
        return view('attendance_logs.dashboard');
    }

    public function clockIn()
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
        $name = $request->input('name');
        $department = $request->input('department');
        $employmentType = $request->input('employment_type');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = AttendanceLog::with('user.masterlist.department')->latest();

        if (!$isAdmin) {
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

        $logs = $query->limit(100)->get();

        return view('attendance_logs.dashboard', [
            'logs' => $logs,
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
        $isAdmin = auth()->user()->authAssignments()->where('item_name', 'Administrator')->exists();
        
        if (!$isAdmin) {
            return redirect()->route('attendance.dashboard')->with('error', 'Unauthorized access');
        }

        $presentEmployees = AttendanceLog::where('mode', 'Attend')
            ->whereDate('date', today())
            ->with('user.masterlist.department')
            ->distinct('user_id')
            ->get();

        return view('attendance_logs.present-today', compact('presentEmployees'));
    }

    public function reports(Request $request)
    {
        $isAdmin = auth()->user()->authAssignments()->where('item_name', 'Administrator')->exists();
        
        if (!$isAdmin) {
            return redirect()->route('attendance.dashboard')->with('error', 'Unauthorized access');
        }

        $totalEmployees = User::count();
        $presentToday = AttendanceLog::where('mode', 'Attend')
            ->whereDate('date', today())
            ->distinct('user_id')
            ->count();
        $absentToday = $totalEmployees - $presentToday;
        
        $attendanceByDepartment = AttendanceLog::where('mode', 'Attend')
            ->whereDate('date', today())
            ->with('user.masterlist.department')
            ->get()
            ->groupBy('user.masterlist.department.title')
            ->map(function($logs) {
                return $logs->count();
            });

        // WFH filters
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

        $departments = \App\Models\Department::orderBy('title')->pluck('title');

        return view('attendance_logs.reports', compact('totalEmployees', 'presentToday', 'absentToday', 'attendanceByDepartment', 'wfhAccomplishments', 'wfhDate', 'wfhDepartment', 'departments'));
    }
    public function exportWFHPdf(Request $request)
        {
            $isAdmin = auth()->user()->authAssignments()->where('item_name', 'Administrator')->exists();
            if (!$isAdmin) {
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
}
