<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index() {

        $reports_total = Report::where('status','!=','Void')->count();
        $report_resolved = Report::where('status', 'done')->count();
        $reports_pending = Report::where('status', 'Pending')->count();
        $reports_ongoing = Report::where('status', 'Ongoing')->count();

        $months = collect(range(1, 12))->mapWithKeys(fn($month) => [$month => 0]);

        $data = DB::table('reports')
            ->selectRaw('MONTH(request_datetime) as month, COUNT(*) as total')
            ->where('status','!=','Void')
            ->groupByRaw('MONTH(request_datetime)')
            ->pluck('total', 'month')
            ->toArray();

        $results = $months->merge($data);

        $formattedResults = $results->mapWithKeys(function ($count, $month) {
            if ($month >= 1 && $month <= 12) {
                return [Carbon::createFromFormat('!m', $month)->format('F') => $count];
            }
            return [];
        });


        $labels = array_keys($formattedResults->toArray());
        $values = array_values($data);

        //department showdown
        $department_data = DB::table('reports')
        ->leftJoin('departments', 'reports.department_id', '=', 'departments.id')
        ->selectRaw('departments.title as department, COUNT(*) as total')
        ->where('reports.status','!=','Void')
        ->groupBy('departments.title')
        ->pluck('total', 'department')
        ->toArray();
        $formattedData = [];
        foreach ($department_data as $dept => $count) {
            $formattedData[] = ['name' => $dept, 'y' => $count];
        }

        //customer satisfaction
        $question1 = Feedback::avg('answer1');
        $question2 = Feedback::avg('answer3');
        //scorecad
        $averageScore = ($question1 + $question2) / 2;
        $satisfaction = ($averageScore/5) * 100;

        //technical staff efficiency
        $results = Report::selectRaw('count(reports.issues_id) as count, issues.title as title')
                ->leftJoin('issues', 'reports.issues_id', '=', 'issues.id')
                ->where('reports.status','!=','Void')
                ->groupBy('reports.issues_id', 'issues.title') // Add 'issues.title' here
                ->orderBy('count', 'desc') // Order by count in descending order
                ->get();
        
        $weeklyData = DB::table('reports')
        ->selectRaw(
            'YEAR(created_at) as year, 
                WEEK(created_at) as week, 
                MIN(DATE(created_at)) as start_date, 
                MAX(DATE(created_at)) as end_date, 
                COUNT(*) as total'
        )
        ->groupBy('year', 'week')
        ->orderBy('year')
        ->orderBy('week')
        ->get();

   

        $dateRanges = $weeklyData->map(function ($data) {
            $start = \Carbon\Carbon::parse($data->start_date)->format('M j');
            $end = \Carbon\Carbon::parse($data->end_date)->format('M j');
            return "$start to $end";
        });

        // $totals = $weeklyData->pluck('total')->toArray();


       $users = \DB::table('users')
        ->leftJoin('resolve', 'users.id', '=', 'resolve.user_id')
        ->select('users.name', \DB::raw('COUNT(resolve.id) as count'))
        ->whereIn('users.team', ['NIS', 'Systems'])
        ->groupBy('users.id', 'users.name')
        ->get()
        ->map(function ($item) {
            return [
                'name' => $item->name,
                'y' => (int) $item->count,
                'drilldown' => $item->name,
            ];
        })
        ->toArray();

        $recurringIssues = \DB::table('issues')
        ->leftJoin('reports', 'reports.issues_id', '=', 'issues.id')
        ->select('issues.title', \DB::raw('COUNT(reports.id) as data'))
        ->where('reports.status','!=','Void')
        ->groupBy('issues.title')
        ->get()
        ->filter(function ($data) {
            return $data->data >= 3;
        })
        ->map(fn($data) => [
        'name' => $data->title,
        'y' => (int) $data->data,
        'color' => '#14B8A6',
        ])->values();

               
               

                       // exit;
        return view('dashboard.index', [
            'reports_total' => $reports_total,
            'report_resolved' => $report_resolved,
            'reports_pending' => $reports_pending,
            'reports_ongoing' => $reports_ongoing,
            'labels' => $labels,
            'values' => $values,
            'satisfaction'  => $satisfaction,
            'results'   =>  $results,
            'userData' => $users,
            'recurringIssues' => $recurringIssues,
            'formattedData'   => $formattedData,
        ]);

    
        }
}
