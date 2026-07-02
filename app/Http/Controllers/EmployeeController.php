<?php

namespace App\Http\Controllers;

use App\Models\EmployeeMasterlist;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
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

            $chartData['All'][] = ['name' => $name, 'y' => $allCountsMap[$id] ?? 0];
            foreach ($types as $typeOption) {
                if ($typeOption !== 'All') {
                    $chartData[$typeOption][] = ['name' => $name, 'y' => $typeCountsMap[$typeOption][$id] ?? 0];
                }
            }
        }

        if (isset($allCountsMap['NoDept'])) {
            $chartData['All'][] = ['name' => 'No Department', 'y' => $allCountsMap['NoDept']];
            foreach ($types as $typeOption) {
                if ($typeOption !== 'All') {
                    $chartData[$typeOption][] = ['name' => 'No Department', 'y' => $typeCountsMap[$typeOption]['NoDept'] ?? 0];
                }
            }
        }

        $employees = $query->latest()->paginate(20)->appends($request->query());
        
        return view('employee-list.index', compact('employees', 'departments', 'chartData'));
    }

    public function create()
    {
        $departments = Department::where('active', 1)->get();
        return view('employee-list.create', compact('departments'));
    }

    public function store(Request $request)
    {
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
        ]);

        EmployeeMasterlist::create($validated);
        return redirect()->route('employee-list.index')->with('success', 'Employee added successfully');
    }

    public function show(EmployeeMasterlist $employee)
    {
        return view('employee-list.show', compact('employee'));
    }

    public function edit(EmployeeMasterlist $employee)
    {
        $departments = Department::where('active', 1)->get();
        return view('employee-list.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, EmployeeMasterlist $employee)
    {
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
        ]);

        $employee->update($validated);
        return redirect()->route('employee-list.index')->with('success', 'Employee updated successfully');
    }

    public function destroy(EmployeeMasterlist $employee)
    {
        $employee->delete();
        return redirect()->route('employee-list.index')->with('success', 'Employee deleted successfully');
    }

    public function export(Request $request)
    {
        $filters = $request->only(['search', 'department', 'status', 'type']);
        $filters['status'] = 'Active';
        return Excel::download(new EmployeesExport($filters), 'active_employees_' . now()->format('Y-m-d') . '.xlsx');
    }
}
