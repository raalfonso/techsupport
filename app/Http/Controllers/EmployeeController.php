<?php

namespace App\Http\Controllers;

use App\Models\EmployeeMasterlist;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    private function checkAuthorization()
    {
        $user = auth()->user();
        $isAdmin = $user->authAssignments()->where('item_name', 'Administrator')->exists();
        $isHRAdmin = $user->authAssignments()->where('item_name', 'HR_admin')->exists();

        if (!$isAdmin && !$isHRAdmin) {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(
                redirect()->route('attendance.dashboard')->with('error', 'Unauthorized access')
            );
        }
    }

    public function index(Request $request)
    {
        $this->checkAuthorization();
        $query = EmployeeMasterlist::with('department');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('employee_number', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        // Filter by department
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        // Clone query after department but before status filter for the Highcharts chart
        $chartQuery = clone $query;
        $chartQuery->where('employment_status', 'Active');

        // Filter by employment status
        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }

        // Filter by employment type
        if ($request->filled('type')) {
            $query->where('employment_type', $request->type);
        }

        // Get counts grouped by department and employment type
        $rawCounts = $chartQuery->selectRaw('department_id, employment_type, COUNT(*) as count')
            ->groupBy('department_id', 'employment_type')
            ->get();

        $allCountsMap = [];
        $typeCountsMap = [];

        foreach ($rawCounts as $row) {
            $deptId = $row->department_id ?? 'NoDept';
            $type = $row->employment_type;
            $count = (int) $row->count;

            $allCountsMap[$deptId] = ($allCountsMap[$deptId] ?? 0) + $count;

            if ($type) {
                $typeCountsMap[$type][$deptId] = ($typeCountsMap[$type][$deptId] ?? 0) + $count;
            }
        }

        $departments = Department::where('active', 1)->orderBy('title')->get();
        $types = ['All', 'Permanent', 'Contractual', 'COS', 'COS(DBP)', 'COS(OMNI)'];
        
        $chartData = [
            'All' => []
        ];
        foreach ($types as $typeOption) {
            if ($typeOption !== 'All') {
                $chartData[$typeOption] = [];
            }
        }

        foreach ($departments as $dept) {
            $name = $dept->acronym ?? $dept->title;
            $id = $dept->id;
            $total = $allCountsMap[$id] ?? 0;

            $chartData['All'][] = ['name' => $name, 'y' => $total, 'total' => $total];
            foreach ($types as $typeOption) {
                if ($typeOption !== 'All') {
                    $chartData[$typeOption][] = [
                        'name' => $name, 
                        'y' => $typeCountsMap[$typeOption][$id] ?? 0,
                        'total' => $total
                    ];
                }
            }
        }

        if (isset($allCountsMap['NoDept'])) {
            $total = $allCountsMap['NoDept'];
            $chartData['All'][] = ['name' => 'No Department', 'y' => $total, 'total' => $total];
            foreach ($types as $typeOption) {
                if ($typeOption !== 'All') {
                    $chartData[$typeOption][] = [
                        'name' => 'No Department', 
                        'y' => $typeCountsMap[$typeOption]['NoDept'] ?? 0,
                        'total' => $total
                    ];
                }
            }
        }

        $employees = $query->latest()->paginate(20)->appends($request->query());
        
        return view('employee-list.index', compact('employees', 'departments', 'chartData'));
    }

    public function create()
    {
        $this->checkAuthorization();
        $departments = Department::where('active', 1)->get();
        return view('employee-list.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->checkAuthorization();
        $validated = $request->validate([
            'employee_number' => 'required|unique:employee_masterlists',
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'position' => 'required|string',
            'place_of_assignment' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'date_hired' => 'nullable|date',
            'employment_status' => 'required|string',
            'employment_type' => 'required|string',
            'email' => 'required|email|unique:employee_masterlists',
            'remarks' => 'nullable|string',
            'inactive_date' => 'required_if:employment_status,Inactive|nullable|date',
            'inactive_reason' => 'required_if:employment_status,Inactive|nullable|in:resigned,recall,terminated,retired',
        ]);

        $employee = EmployeeMasterlist::create($validated);

        if ($validated['employment_status'] === 'Inactive') {
            $user = \App\Models\User::where('email', $validated['email'])->first();
            \App\Models\MasterlistHistory::create([
                'user_id' => $user?->id,
                'employee_id' => $employee->employee_number,
                'date' => $validated['inactive_date'],
                'reason' => $validated['inactive_reason'],
            ]);
        }

        return redirect()->route('employee-list.index')->with('success', 'Employee added successfully');
    }

    public function show(EmployeeMasterlist $employee)
    {
        $this->checkAuthorization();
        return view('employee-list.show', compact('employee'));
    }

    public function edit(EmployeeMasterlist $employee)
    {
        $this->checkAuthorization();
        $departments = Department::where('active', 1)->get();
        $latestHistory = $employee->histories()->latest()->first();
        return view('employee-list.edit', compact('employee', 'departments', 'latestHistory'));
    }

    public function update(Request $request, EmployeeMasterlist $employee)
    {
        $this->checkAuthorization();
        $validated = $request->validate([
            'employee_number' => 'required|unique:employee_masterlists,employee_number,' . $employee->id,
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'position' => 'required|string',
            'place_of_assignment' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'date_hired' => 'nullable|date',
            'employment_status' => 'required|string',
            'employment_type' => 'required|string',
            'email' => 'required|email|unique:employee_masterlists,email,' . $employee->id,
            'remarks' => 'nullable|string',
            'inactive_date' => 'required_if:employment_status,Inactive|nullable|date',
            'inactive_reason' => 'required_if:employment_status,Inactive|nullable|in:resigned,recall,terminated,retired',
        ]);

        $wasInactive = $employee->employment_status === 'Inactive';

        $employee->update($validated);

        if ($validated['employment_status'] === 'Inactive') {
            $user = \App\Models\User::where('email', $validated['email'])->first();
            $latestHistory = $employee->histories()->latest()->first();

            if ($latestHistory && $wasInactive) {
                $latestHistory->update([
                    'user_id' => $user?->id,
                    'date' => $validated['inactive_date'],
                    'reason' => $validated['inactive_reason'],
                ]);
            } else {
                \App\Models\MasterlistHistory::create([
                    'user_id' => $user?->id,
                    'employee_id' => $employee->employee_number,
                    'date' => $validated['inactive_date'],
                    'reason' => $validated['inactive_reason'],
                ]);
            }
        }

        return redirect()->route('employee-list.index')->with('success', 'Employee updated successfully');
    }

    public function destroy(EmployeeMasterlist $employee)
    {
        $this->checkAuthorization();
        $employee->delete();
        return redirect()->route('employee-list.index')->with('success', 'Employee deleted successfully');
    }

    public function export(Request $request)
    {
        $this->checkAuthorization();
        $filters = $request->only(['search', 'department', 'status', 'type']);
        $filters['status'] = 'Active';
        return Excel::download(new EmployeesExport($filters), 'active_employees_' . now()->format('Y-m-d') . '.xlsx');
    }
}
