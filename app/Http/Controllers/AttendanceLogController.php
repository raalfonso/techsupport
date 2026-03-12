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
        $name = $request->input('name');
        $department = $request->input('department');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = AttendanceLog::where('user_id', auth()->id())
            ->with('user.surveyEmployee.department')
            ->latest();

        if ($name) {
            $query->whereHas('user', function ($q) use ($name) {
                $q->where('name', 'like', '%' . $name . '%');
            });
        }

        if ($department) {
            $query->whereHas('user.surveyEmployee.department', function ($q) use ($department) {
                $q->where('title', 'like', '%' . $department . '%');
            });
        }

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        $logs = $query->limit(50)->get();

        return view('attendance_logs.dashboard', [
            'logs' => $logs,
            'filters' => [
                'name' => $name,
                'department' => $department,
                'start_date' => $startDate,
                'end_date' => $endDate
            ]
        ]);
    }

    public function getEmployees(Request $request)
    {
        $search = $request->input('search', '');
        $employees = User::with('surveyEmployee')
            ->where('name', 'like', '%' . $search . '%')
            ->limit(10)
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'employee_id' => $user->surveyEmployee->employee_id ?? 'N/A'
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
}
