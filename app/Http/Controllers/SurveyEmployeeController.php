<?php

namespace App\Http\Controllers;

use App\Models\SurveyEmployees;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
}
