<?php

namespace App\Http\Controllers;

use App\Models\EmployeeMasterlist;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeMasterlistController extends Controller
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
        
        return view('employee_masterlist.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('active', 1)->get();
        return view('employee_masterlist.create', compact('departments'));
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
        return redirect()->route('employee-masterlist.index')->with('success', 'Employee added successfully');
    }

    public function show(EmployeeMasterlist $employeeMasterlist)
    {
        return view('employee_masterlist.show', compact('employeeMasterlist'));
    }

    public function edit(EmployeeMasterlist $employeeMasterlist)
    {
        $departments = Department::where('active', 1)->get();
        return view('employee_masterlist.edit', compact('employeeMasterlist', 'departments'));
    }

    public function update(Request $request, EmployeeMasterlist $employeeMasterlist)
    {
        $validated = $request->validate([
            'employee_number' => 'required|unique:employee_masterlists,employee_number,' . $employeeMasterlist->id,
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'position' => 'required|string',
            'place_of_assignment' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'date_hired' => 'nullable|date',
            'employment_status' => 'required|string',
            'employment_type' => 'required|string',
            'email' => 'required|email|unique:employee_masterlists,email,' . $employeeMasterlist->id,
        ]);

        $employeeMasterlist->update($validated);
        return redirect()->route('employee-masterlist.index')->with('success', 'Employee updated successfully');
    }

    public function destroy(EmployeeMasterlist $employeeMasterlist)
    {
        $employeeMasterlist->delete();
        return redirect()->route('employee-masterlist.index')->with('success', 'Employee deleted successfully');
    }

    public function importForm()
    {
        return view('employee_masterlist.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        try {
            $file = $request->file('csv_file');
            $handle = fopen($file->getRealPath(), 'r');
            
            $header = fgetcsv($handle);
            $header = array_map('trim', $header);
            
            $imported = 0;
            $errors = [];
            $row = 1;

            DB::beginTransaction();

            while (($data = fgetcsv($handle)) !== false) {
                $row++;
                
                if (empty(array_filter($data))) {
                    continue;
                }

                $data = array_map('trim', $data);
                
                if (count($data) !== count($header)) {
                    continue;
                }
                
                $record = array_combine($header, $data);

                try {
                    // Helper function to get value from record with multiple possible keys
                    $getValue = function($keys) use ($record) {
                        foreach ((array)$keys as $key) {
                            if (isset($record[$key]) && !empty($record[$key])) {
                                return $record[$key];
                            }
                        }
                        return '';
                    };

                    $empNum = $getValue(['employee_number', 'Employee Number', 'emp_number', 'Emp Number']);
                    $firstName = $getValue(['first_name', 'First Name', 'fname', 'First']);
                    $lastName = $getValue(['last_name', 'Last Name', 'lname', 'Last']);
                    
                    if (empty($empNum) || empty($firstName) || empty($lastName)) {
                        $errors[] = "Row {$row}: Headers detected: " . implode(', ', array_keys($record));
                        continue;
                    }

                    $deptId = $getValue(['department_id', 'Department ID', 'dept_id', 'Dept ID', 'department', 'Department']);
                    $departmentId = null;
                    
                    if (!empty($deptId)) {
                        // Try to find department by ID first
                        $dept = Department::find($deptId);
                        if ($dept) {
                            $departmentId = $dept->id;
                        } else {
                            // If not found by ID, try to find by title
                            $dept = Department::where('title', 'like', '%' . $deptId . '%')->first();
                            if ($dept) {
                                $departmentId = $dept->id;
                            }
                        }
                    }

                    $position = $getValue(['position', 'Position', 'job_title', 'Job Title']);
                    $middleName = $getValue(['middle_name', 'Middle Name', 'mname', 'Middle']);
                    $placeAssign = $getValue(['place_of_assignment', 'Place of Assignment', 'assignment', 'Assignment']);
                    $dateHired = $getValue(['date_hired', 'Date Hired', 'hire_date', 'Hire Date']);
                    $empStatus = $getValue(['employment_status', 'Employment Status', 'status', 'Status']) ?: 'Active';
                    $empType = $getValue(['employment_type', 'Employment Type', 'type', 'Type']) ?: 'Permanent';
                    $email = $getValue(['email', 'Email', 'email_address', 'Email Address']);

                    EmployeeMasterlist::updateOrCreate(
                        ['employee_number' => $empNum],
                        [
                            'last_name' => $lastName,
                            'first_name' => $firstName,
                            'middle_name' => $middleName,
                            'position' => $position,
                            'place_of_assignment' => $placeAssign,
                            'department_id' => $departmentId,
                            'date_hired' => !empty($dateHired) ? $dateHired : null,
                            'employment_status' => $empStatus,
                            'employment_type' => $empType,
                            'email' => $email,
                        ]
                    );
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Row {$row}: {$e->getMessage()}";
                }
            }

            fclose($handle);
            DB::commit();

            $message = "Imported {$imported} employees successfully.";
            if (!empty($errors)) {
                $message .= " Errors: " . implode(" | ", array_slice($errors, 0, 5));
            }

            return redirect()->route('employee-masterlist.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
