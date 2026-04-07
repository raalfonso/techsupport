<?php

namespace App\Http\Controllers;

use App\Models\ItSurvey;
use App\Models\ItSurveyIssue;
use App\Models\EmployeeMasterlist;
use Illuminate\Http\Request;

class ItSurveyController extends Controller
{
    public function index()
    {
        $surveys = ItSurvey::with(['issue', 'employee'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalSurveys = ItSurvey::count();

        // Response Time Statistics (Question 1)
        $responseTimeStats = ItSurvey::selectRaw('answer_question_1, COUNT(*) as count')
            ->whereNotNull('answer_question_1')
            ->groupBy('answer_question_1')
            ->orderBy('answer_question_1', 'desc')
            ->get();

        $responseTimeLabels = ['Within a few minutes', 'Within a few hours', 'Within the day', 'The next day', 'After a few days'];
        $responseTimeData = array_fill(0, 5, 0);
        foreach ($responseTimeStats as $stat) {
            $index = 5 - (int)$stat->answer_question_1;
            $responseTimeData[$index] = $stat->count;
        }

        // Issue Resolution Statistics (Question 2)
        $resolvedCount = ItSurvey::where('answer_question_2', 'Yes')->count();
        $unresolvedCount = ItSurvey::where('answer_question_2', 'No')->count();
        $resolutionRate = $totalSurveys > 0 ? round(($resolvedCount / $totalSurveys) * 100, 2) : 0;

        // Service Rating Statistics (Question 3)
        $serviceRatingStats = ItSurvey::selectRaw('answer_question_3, COUNT(*) as count')
            ->whereNotNull('answer_question_3')
            ->groupBy('answer_question_3')
            ->orderBy('answer_question_3', 'desc')
            ->get();

        $serviceRatingLabels = ['Excellent', 'Very Satisfactory', 'Satisfactory', 'Unsatisfactory', 'Poor'];
        $serviceRatingData = array_fill(0, 5, 0);
        foreach ($serviceRatingStats as $stat) {
            $index = 5 - (int)$stat->answer_question_3;
            $serviceRatingData[$index] = $stat->count;
        }

        // Average ratings
        $avgResponseTime = ItSurvey::whereNotNull('answer_question_1')->avg('answer_question_1');
        $avgServiceRating = ItSurvey::whereNotNull('answer_question_3')->avg('answer_question_3');

        // Top issues surveyed
        $topIssues = ItSurvey::select('issues_id', \DB::raw('COUNT(*) as count'))
            ->with('issue')
            ->groupBy('issues_id')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        // IT Employee Performance Statistics
        $employeeStats = ItSurvey::select('employee_number')
            ->selectRaw('COUNT(*) as total_surveys')
            ->selectRaw('AVG(CAST(answer_question_1 AS DECIMAL(10,2))) as avg_response_time')
            ->selectRaw('AVG(CAST(answer_question_3 AS DECIMAL(10,2))) as avg_service_rating')
            ->selectRaw('SUM(CASE WHEN answer_question_2 = "Yes" THEN 1 ELSE 0 END) as resolved_count')
            ->with('employee')
            ->whereNotNull('employee_number')
            ->groupBy('employee_number')
            ->orderBy('total_surveys', 'desc')
            ->get();

        $employeeNames = [];
        $employeeSurveyCount = [];
        $employeeAvgRating = [];
        $employeeResolutionRate = [];

        foreach ($employeeStats as $stat) {
            if ($stat->employee) {
                $name = $stat->employee->first_name . ' ' . $stat->employee->last_name;
                $employeeNames[] = $name;
                $employeeSurveyCount[] = $stat->total_surveys;
                $employeeAvgRating[] = round($stat->avg_service_rating, 2);
                $employeeResolutionRate[] = $stat->total_surveys > 0 ? round(($stat->resolved_count / $stat->total_surveys) * 100, 2) : 0;
            }
        }

        return view('it_survey.dashboard', compact(
            'surveys',
            'totalSurveys',
            'responseTimeLabels',
            'responseTimeData',
            'resolvedCount',
            'unresolvedCount',
            'resolutionRate',
            'serviceRatingLabels',
            'serviceRatingData',
            'avgResponseTime',
            'avgServiceRating',
            'topIssues',
            'employeeStats',
            'employeeNames',
            'employeeSurveyCount',
            'employeeAvgRating',
            'employeeResolutionRate'
        ));
    }

    public function form(Request $request)
    {
        $issues = ItSurveyIssue::where('is_active', true)->orderBy('id', 'asc')->get();
        
        // Get employees who have user accounts with IT_user or Administrator levels
        // Assuming level 1 = Administrator, level 2 = IT_user (adjust as needed)
        $employees = EmployeeMasterlist::select('employee_masterlists.employee_number', 'employee_masterlists.first_name', 'employee_masterlists.last_name')
            ->join('users', 'employee_masterlists.email', '=', 'users.email')
            ->whereIn('users.level', [1, 2,3]) // Adjust these level values as needed
            ->orderBy('employee_masterlists.last_name', 'asc')
            ->get()
            ->map(function($employee) {
                return [
                    'employee_number' => $employee->employee_number,
                    'name' => $employee->last_name . ', ' . $employee->first_name,
                ];
            });

        return view('it_survey.form', compact('issues', 'employees'));
    }

    public function submit(Request $request)
    {
        $fields = $request->validate([
            'issues_id' => 'required|exists:it_survey_issues,id',
            'employee_number' => 'nullable|exists:employee_masterlists,employee_number',
            'answer_question_1' => 'nullable|string|max:255',
            'answer_question_2' => 'nullable|string|max:255',
            'answer_question_3' => 'nullable|string|max:255',
            'answer_question_4' => 'nullable|string|max:255',
            'suggestion' => 'nullable|string',
            'name' => 'nullable|string|max:255',
            'other_issues' => 'nullable|string|max:255',
        ]);

        ItSurvey::create($fields);

        return redirect()->route('it-survey.thank-you')->with('success', 'Thank you for your feedback!');
    }

    public function thankYou()
    {
        return view('it_survey.thankyou');
    }

    public function exportResults(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = ItSurvey::with(['issue', 'employee']);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $surveys = $query->get();

        return view('it_survey.export', compact('surveys', 'startDate', 'endDate'));
    }
}
