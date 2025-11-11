<?php

namespace App\Http\Controllers;

use App\Models\SurveyEmployees;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SurveyEmployeeController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        // Validate and store the employee survey data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:survey_employees,email',
            'department_id' => 'required|exists:departments,id',
            // Add other necessary fields
        ]);
        $data['user_survey_id'] = auth()->user()->id; // Assuming the authenticated user is the survey creator

        SurveyEmployees::create($data);

        return redirect()->route('survey.dashboard')->with('success', 'Employee registered successfully.');
    }

    public function edit(Request $request)
    {
        // get id first
        $id = $request->input('id');

        // validate and ignore current record for unique email
        $data = $request->validate([
            'id' => ['required','exists:survey_employees,id'],
            'name' => ['required','string','max:255'],
            'email' => ['required','email', Rule::unique('survey_employees','email')->ignore($id)],
            'department_id' => ['sometimes','exists:departments,id'],
            // add other fields you expect to update
        ]);

        // remove id from the update payload
        $updateData = $request->only(['name','email','department_id']);

        // Option A: simple query update (bypasses $fillable)
        SurveyEmployees::where('id', $id)->update($updateData);

        // Option B (preferred if you set $fillable on the model):
        // $employee = SurveyEmployees::findOrFail($id);
        // $employee->update($updateData);

        return redirect()->route('survey.dashboard')->with('success', 'Employee updated successfully.');
    }
}
