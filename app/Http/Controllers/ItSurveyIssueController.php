<?php

namespace App\Http\Controllers;

use App\Models\ItSurveyIssue;
use Illuminate\Http\Request;

class ItSurveyIssueController extends Controller
{
    public function index()
    {
        $issues = ItSurveyIssue::orderBy('created_at', 'desc')->paginate(10);
        return view('it_survey_issues.index', compact('issues'));
    }

    public function create()
    {
        return view('it_survey_issues.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        ItSurveyIssue::create($validated);

        return redirect()->route('it-survey-issues.index')->with('success', 'Issue created successfully.');
    }

    public function show(ItSurveyIssue $itSurveyIssue)
    {
        return view('it_survey_issues.show', compact('itSurveyIssue'));
    }

    public function edit(ItSurveyIssue $itSurveyIssue)
    {
        return view('it_survey_issues.edit', compact('itSurveyIssue'));
    }

    public function update(Request $request, ItSurveyIssue $itSurveyIssue)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $itSurveyIssue->update($validated);

        return redirect()->route('it-survey-issues.index')->with('success', 'Issue updated successfully.');
    }

    public function destroy(ItSurveyIssue $itSurveyIssue)
    {
        $itSurveyIssue->delete();

        return redirect()->route('it-survey-issues.index')->with('success', 'Issue deleted successfully.');
    }
}
