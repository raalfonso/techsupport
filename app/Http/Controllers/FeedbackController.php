<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Report;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use Illuminate\Http\Request;
class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'report_id' => 'required',
            'accuracy_of_service' => 'nullable',
            'response_time' => 'nullable',
            'comments' => 'nullable',
            'client_name' => 'nullable',
            'answer1' => 'nullable',
            'answer2' => 'nullable',
            'answer3' => 'nullable',
            'reason'   => 'nullable|max:255',
            'suggestion'  => 'nullable|max:255',
        ]);

        $reportId = $request->input('report_id');
        $report = Report::find($reportId);

        $accuracy = $request->input('accuracy_of_service', $request->input('answer1'));
        $responseTime = $request->input('response_time', $request->input('answer2', $request->input('answer3')));
        $comments = $request->input('comments', $request->input('reason'));
        $clientName = $request->input('client_name', $request->input('suggestion'));

        // Convert survey ratings (2=Super Like, 1=Like, 0=Dislike) to 1-5 scale for Feedback model average scores
        $answer1 = ($accuracy == '2') ? 5 : (($accuracy == '1') ? 4 : (($accuracy == '0') ? 1 : ($request->input('answer1') ?? 5)));
        $answer2 = ($responseTime == '2') ? 5 : (($responseTime == '1') ? 4 : (($responseTime == '0') ? 1 : ($request->input('answer2') ?? 5)));
        $answer3 = $answer2;

        $feedback = Feedback::create([
            'report_id' => $reportId,
            'answer1' => $answer1,
            'answer2' => $answer2,
            'answer3' => $answer3,
            'reason' => $comments,
            'suggestion' => $clientName,
        ]);

        if ($report) {
            $report->update(['feedback' => 'Yes']);

            // Save to survey_report table as well
            try {
                \App\Models\SurveyReport::create([
                    'department_id' => $report->department_id,
                    'survey_date' => now()->format('Y-m-d'),
                    'survey_employees_id' => $report->survey_employees_id ?? 1,
                    'accuracy_of_service' => is_numeric($accuracy) ? (int)$accuracy : 2,
                    'response_time' => is_numeric($responseTime) ? (int)$responseTime : 2,
                    'comments' => $comments,
                    'client_name' => $clientName ?? $report->client?->name,
                ]);
            } catch (\Exception $e) {
                // Ignore if survey_employees_id is missing or fails
            }
        }

        return redirect()->route('home.employeeReport')->with('success', 'Thank you! Your feedback has been submitted.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
