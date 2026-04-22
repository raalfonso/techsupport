<?php

namespace App\Http\Controllers;

use App\Models\EmployeeMasterlist;
use App\Models\Department;
use Illuminate\Http\Request;

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

        // Filter by employment status
        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }

        // Filter by employment type
        if ($request->filled('type')) {
            $query->where('employment_type', $request->type);
        }

        $employees = $query->latest()->paginate(20)->appends($request->query());
        $departments = Department::where('active', 1)->orderBy('title')->get();
        
        return view('employee-list.index', compact('employees', 'departments'));
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
        ]);

        $employee->update($validated);
        return redirect()->route('employee-list.index')->with('success', 'Employee updated successfully');
    }

    public function destroy(EmployeeMasterlist $employee)
    {
        $employee->delete();
        return redirect()->route('employee-list.index')->with('success', 'Employee deleted successfully');
    }
}
