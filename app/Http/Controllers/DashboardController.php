<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index() {

        $reports_total = Report::count();
        $report_resolved = Report::where('status', 'done')->count();
        $reports_pending = Report::where('status', 'Pending')->count();
        $reports_ongoing = Report::where('status', 'Ongoing')->count();

        $months = collect(range(1, 12))->mapWithKeys(fn($month) => [$month => 0]);

        $data = DB::table('reports')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereNotNull('created_at')
            ->groupByRaw('MONTH(created_at)')
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
        $values = array_values($formattedResults->toArray());

        // print_r($results);

        // exit;
        return view('dashboard.index', [
            'reports_total' => $reports_total,
            'report_resolved' => $report_resolved,
            'reports_pending' => $reports_pending,
            'reports_ongoing' => $reports_ongoing,
            'labels' => $labels,
            'values' => $values,
        ]);

    
        }
}
