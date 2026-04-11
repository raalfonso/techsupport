<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index(Request $request) {
        $selectedYear = $request->get('year', date('Y'));
        
        $user_level = auth()->user()->level;
        $user_team = auth()->user()->team;
        $user_id = auth()->user()->id;     
        
        $user = auth()->user();
        
        $reports_total = Report::where('status','!=','Void')->whereYear('request_datetime', $selectedYear)->count();
        $report_resolved = Report::where('status', 'done')->whereYear('request_datetime', $selectedYear)->count();
        $reports_pending = Report::where('status', 'Pending')->whereYear('request_datetime', $selectedYear)->count();
        $reports_ongoing = Report::where('status', 'Ongoing')->whereYear('request_datetime', $selectedYear)->count();

        // 1–12 months in correct order
        $months = collect([
                1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0,
                7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0
            ]);

            $data = DB::table('reports')
                ->selectRaw('MONTH(request_datetime) as month, COUNT(*) as total')
                ->where('status','!=','Void')
                ->whereYear('request_datetime', $selectedYear)
                ->groupByRaw('MONTH(request_datetime)')
                ->pluck('total', 'month');  // Example: [9 => 37, 10 => 4, 11 => 2]

            // Overwrite only the months that exist in the DB result
            $filled = $months->map(function ($default, $month) use ($data) {
                return $data[$month] ?? 0;
            });

            // Convert numeric months → Month Names
            $final = $filled->mapWithKeys(function ($value, $month) {
                return [Carbon::create()->month($month)->format('F') => $value];
            });

        $labels = array_keys($final->toArray());
        $values = array_values($final->toArray());

        //department showdown
        $department_data = DB::table('reports')
        ->leftJoin('departments', 'reports.department_id', '=', 'departments.id')
        ->selectRaw('departments.title as department, COUNT(*) as total')
        ->where('reports.status','!=','Void')
        ->whereYear('reports.request_datetime', $selectedYear)
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
        ->leftJoin('reports', 'resolve.report_id', '=', 'reports.id')
        ->select('users.name', \DB::raw('COUNT(CASE WHEN reports.status != "Void" AND YEAR(reports.request_datetime) = ' . $selectedYear . ' THEN reports.id END) as count'))
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

        $usersResponse = \DB::table('users')
        ->leftJoin('reports', 'users.id', '=', 'reports.response_by')
        ->select('users.name', \DB::raw('COUNT(CASE WHEN reports.status != "Void" AND YEAR(reports.request_datetime) = ' . $selectedYear . ' THEN reports.id END) as count'))
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

        // print_r($usersResponse);
        // exit;

        $recurringIssues = \DB::table('issues')
        ->leftJoin('reports', 'reports.issues_id', '=', 'issues.id')
        ->leftJoin('mains', 'mains.id', '=', 'issues.mains_id')
        ->select('issues.title', \DB::raw('COUNT(reports.id) as data'))
        ->where('reports.status','!=','Void')
        ->where('mains.type', '=', 'Report')
        ->whereBetween('reports.request_datetime', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])
        ->groupBy('issues.title')
        ->get()
        ->filter(function ($data) {
            return $data->data >= 3;
        })
        ->map(fn($data) => [
        'name' => $data->title,
        'y' => (int) $data->data,
        'color' => '#344fd9',
        ])->values();

        // New chart data
        $avgResponseTime = DB::table('reports')
            ->whereNotNull('response_datetime')
            ->where('status','!=','Void')
            ->whereYear('request_datetime', $selectedYear)
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, request_datetime, response_datetime)) as avg_minutes')
            ->value('avg_minutes') ?? 0;
            
        $issueCategories = DB::table('reports')
            ->leftJoin('issues', 'reports.issues_id', '=', 'issues.id')
            ->leftJoin('categories', 'issues.category_id', '=', 'categories.id')
            ->select('categories.title', DB::raw('COUNT(*) as count'))
            ->where('reports.status','!=','Void')
            ->whereYear('reports.request_datetime', $selectedYear)
            ->groupBy('categories.title')
            ->get()
            ->map(fn($item) => ['name' => $item->title, 'y' => (int)$item->count]);
            
        $resolutionTrend = collect(range(1, 12))->map(function($month) use ($selectedYear) {
            $avgMinutes = DB::table('reports')
                ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, response_datetime, resolve_datetime)) as avg_minutes')
                ->whereNotNull('resolve_datetime')
                ->where('status', 'Done')
                ->whereMonth('resolve_datetime', $month)
                ->whereYear('resolve_datetime', $selectedYear)
                ->value('avg_minutes');
            return round($avgMinutes ?? 0);
        });
            
        $statusDistribution = [
            ['name' => 'Pending', 'y' => $reports_pending],
            ['name' => 'Ongoing', 'y' => $reports_ongoing], 
            ['name' => 'Resolved', 'y' => $report_resolved]
        ];
        
        $satisfactionTrend = DB::table('feedback')
            ->selectRaw('MONTH(created_at) as month, AVG((answer1 + answer3)/2) * 20 as satisfaction')
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(fn($item) => round($item->satisfaction ?? 0));
            
        $peakHours = DB::table('reports')
            ->selectRaw('HOUR(request_datetime) as hour, DAYOFWEEK(request_datetime) - 1 as day, COUNT(*) as count')
            ->where('status','!=','Void')
            ->whereYear('request_datetime', $selectedYear)
            ->groupBy('hour', 'day')
            ->get()
            ->map(function($item) {
                return [$item->hour, $item->day, $item->count];
            });

               
               

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
            'responseData' => $usersResponse,
            'recurringIssues' => $recurringIssues,
            'formattedData'   => $formattedData,
            'avgResponseTime' => $avgResponseTime,
            'issueCategories' => $issueCategories,
            'resolutionTrend' => $resolutionTrend,
            'statusDistribution' => $statusDistribution,
            'satisfactionTrend' => $satisfactionTrend,
            'peakHours' => $peakHours,
            'selectedYear' => $selectedYear,
        ]);
        }

        

    
        
}
