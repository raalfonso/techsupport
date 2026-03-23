<?php

namespace App\Http\Controllers;

use App\Models\Signatory;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class SignatoryController extends Controller
{
    public function index()
    {
        $signatories = Signatory::with('employee.masterlist', 'department')->latest()->paginate(15);
        return view('signatory.index', compact('signatories'));
    }

    public function create()
    {
        $employees = User::with('masterlist')->orderBy('name')->get();
        $departments = Department::orderBy('title')->get();
        return view('signatory.create', compact('employees', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'   => 'required|exists:users,id',
            'position'      => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]);

        Signatory::create($request->only('employee_id', 'position', 'department_id'));

        return redirect()->route('signatory.index')->with('success', 'Signatory created successfully.');
    }

    public function edit(Signatory $signatory)
    {
        $employees = User::with('masterlist')->orderBy('name')->get();
        $departments = Department::orderBy('title')->get();
        return view('signatory.edit', compact('signatory', 'employees', 'departments'));
    }

    public function update(Request $request, Signatory $signatory)
    {
        $request->validate([
            'employee_id'   => 'required|exists:users,id',
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
}
