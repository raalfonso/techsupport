<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['user', 'department'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return response()->json($reports);
    }

    public function show($id)
    {
        $report = Report::with(['user', 'category', 'department'])->find($id);
        
        if (!$report) {
            return response()->json(['error' => 'Report not found'], 404);
        }
        
        return response()->json($report);
    }

    public function store(Request $request)
    {
        try {
            // Check for API token
            $apiToken = $request->header('Authorization') ?? $request->input('api_token');
            if ($apiToken !== 'Bearer ' . env('API_TOKEN', 'your-secret-api-token')) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $request->validate([
                'survey_employees_id' => 'required|integer',
                'department_id' => 'required|integer',
                'issues_id' => 'required|integer'
            ]);

            $report = Report::create([
                'survey_employees_id' => $request->survey_employees_id,
                'department_id' => $request->department_id,
                'issues_id' => $request->issues_id,
                'request_datetime' => now(),
                'status' => 'Pending'
            ]);

            return response()->json($report, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $report = Report::find($id);
        
        if (!$report) {
            return response()->json(['error' => 'Report not found'], 404);
        }

        $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'category_id' => 'exists:categories,id',
            'department_id' => 'exists:departments,id',
            'priority' => 'in:low,medium,high,critical',
            'status' => 'in:Ongoing,Done'
        ]);

        $report->update($request->only([
            'title', 'description', 'category_id', 'department_id', 'priority', 'status'
        ]));

        return response()->json($report->load(['user', 'category', 'department']));
    }

    public function destroy($id)
    {
        $report = Report::find($id);
        
        if (!$report) {
            return response()->json(['error' => 'Report not found'], 404);
        }

        $report->delete();
        
        return response()->json(['message' => 'Report deleted successfully']);
    }

    public function stats()
    {
        $stats = [
            'total' => Report::count(),
            'ongoing' => Report::where('status', 'Ongoing')->count(),
            'done' => Report::where('status', 'Done')->count(),
            'by_priority' => [
                'low' => Report::where('priority', 'low')->count(),
                'medium' => Report::where('priority', 'medium')->count(),
                'high' => Report::where('priority', 'high')->count(),
                'critical' => Report::where('priority', 'critical')->count()
            ]
        ];
        
        return response()->json($stats);
    }
}
