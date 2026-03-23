<?php

namespace App\Http\Controllers;

use App\Models\Signatory;
use App\Models\Department;
use App\Models\EmployeeMasterlist;
use Illuminate\Http\Request;

class SignatoryController extends Controller
{
    public function index()
    {
        $signatories = Signatory::with('employee.department', 'department')->latest()->paginate(15);
        return view('signatory.index', compact('signatories'));
    }

    public function create()
    {
        $departments = Department::orderBy('title')->get();
        return view('signatory.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employee_masterlists,id',
            'position'      => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        Signatory::create($request->only('employee_id', 'position', 'department_id'));

        return redirect()->route('signatory.index')->with('success', 'Signatory created successfully.');
    }

    public function edit(Signatory $signatory)
    {
        $departments = Department::orderBy('title')->get();
        return view('signatory.edit', compact('signatory', 'departments'));
    }

    public function update(Request $request, Signatory $signatory)
    {
        $request->validate([
            'employee_id'   => 'required|exists:employee_masterlists,id',
            'position'      => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        $signatory->update($request->only('employee_id', 'position', 'department_id'));

        return redirect()->route('signatory.index')->with('success', 'Signatory updated successfully.');
    }

    public function destroy(Signatory $signatory)
    {
        $signatory->delete();
        return redirect()->route('signatory.index')->with('success', 'Signatory deleted.');
    }

    // Autocomplete endpoint
    public function searchEmployees(Request $request)
    {
        $q = $request->input('q', '');
        $results = EmployeeMasterlist::with('department')
            ->where(function ($query) use ($q) {
                $query->where('first_name', 'like', "%$q%")
                      ->orWhere('last_name', 'like', "%$q%")
                      ->orWhere('employee_number', 'like', "%$q%");
            })
            ->limit(10)
            ->get()
            ->map(fn($e) => [
                'id'            => $e->id,
                'name'          => $e->full_name,
                'employee_number' => $e->employee_number,
                'department_id' => $e->department_id,
                'department'    => $e->department->title ?? '',
            ]);

        return response()->json($results);
    }
}
