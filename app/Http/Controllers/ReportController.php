<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Resolve;
use App\Models\Category;
use App\Models\Department;
use App\Models\Issues;
use App\Models\User;
use App\Models\Clients;
use App\Models\SurveyEmployees;
use App\Models\History;
use App\Exports\ReportsExport;
use App\Loghistory;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        // Get actual counts from database for stats
        $pendingCount = Report::where('status', 'Pending')->count();
        $ongoingCount = Report::where('status', 'Ongoing')->count();
        $validationCount = Report::where('status', 'For validation')->count();
        
        $reports = Report::whereIn('status', ['Pending', 'Ongoing', 'For validation'])
        ->orderBy('id', 'asc')
        ->paginate(5);

        $countReport = Report::whereIn('status', ['Pending', 'Ongoing', 'For validation'])->count();

        $user_level = auth()->user()->level;
        $user_team = auth()->user()->team;
        $user_id = auth()->user()->id;
       
        // Build query for resolved reports with filters
        $resolvedQuery = Report::whereIn('status', ['Done'])
            ->orderBy('id', 'desc');
            
        // Apply filters
        if ($request->filled('date_from')) {
            $resolvedQuery->whereDate('resolve_datetime', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $resolvedQuery->whereDate('resolve_datetime', '<=', $request->date_to);
        }
        
        if ($request->filled('department_id')) {
            $resolvedQuery->where('department_id', '=', $request->department_id);
        }
        
        if ($request->filled('category_id')) {
            $resolvedQuery->whereHas('Issues', function($q) use ($request) {
                $q->where('category_id', '=', $request->category_id);
            });
        }
        
        if ($request->filled('user_id')) {
            $resolvedQuery->whereHas('resolve', function($q) use ($request) {
                $q->where('user_id', '=', $request->user_id);
            });
        }
        
        $resolved = $resolvedQuery->paginate(5)->withQueryString();
        
        $employees = SurveyEmployees::select('id', 'name','department_id')
        ->get()
        ->map(function($employee) {
            return [
                'id' => $employee->id,
                'name' => $employee->name,
                'department_id' => $employee->department_id,
            ];
        });
     


        $categories = Category::orderBy('title', 'asc')->get();
        $departments = Department::orderBy('title', 'asc')->get();
        $issues = Issues::all();
        $users = User::all();
        // $issues = Issues::orderBy('name','asc')->get();
        

        return view('report.index',[
            'reports' => $reports,
            'categories' => $categories,
            'departments'   => $departments,
            'issues'    => $issues,
            'users' => $users,
            'resolved'  => $resolved,
            'countReport' => $countReport,
            'employees' =>  $employees,
            'pendingCount' => $pendingCount,
            'ongoingCount' => $ongoingCount,
            'validationCount' => $validationCount,
        ]);
    }

    public function getReports()
    {
        $reports = Report::whereIn('status', ['Pending', 'Ongoing', 'For Validation'])
        ->orderBy('id', 'asc')
        ->paginate(15);
        $categories = Category::orderBy('title', 'asc')->get();
        $departments = Department::orderBy('title', 'asc')->get();
        $issues = Issues::all();
        $users = User::all();
        return view('report.reported',[
            'reports' => $reports,
            'categories' => $categories,
            'departments'   => $departments,
            'issues'    => $issues,
            'users' => $users,
        ]);
    }

    public function publicReports()
    {
        $reports = Report::whereIn('status', ['Pending', 'Ongoing', 'For Validation'])
        ->orderBy('id', 'desc')
        ->paginate(20);
        
        return view('report.public',[
            'reports' => $reports,
        ]);
    }

    public function getTotalReports(){
        $countReport = Report::whereIn('status', ['Pending', 'Ongoing', 'For validation'])->count();

        return $countReport;
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

        //  dd($request->all());
        // exit;
        $fields = $request->validate([
            'survey_employees_id' => 'required',
            'department_id' => 'required',
            'issues_id' => 'required',
            'request_datetime' => 'required',
        ]);

        // Convert request_datetime to proper format
        $fields['request_datetime'] = Carbon::parse($fields['request_datetime'])->format('Y-m-d H:i:s');

       
    
        Report::create($fields);
     
        return redirect()->route('report.index', ['success' => 'New request created successfully!']);
    }

    public function emergency(Request $request)
    {
        $fields = $request->validate([
            'survey_employees_id' => 'required',
            'department_id' => 'required',
            'issues_id' => 'required',
            'location' => 'string',
        ]);

        $fields['request_datetime'] = now();
        $fields['response_datetime'] = now();
        $fields['validation_date_time'] = now();
        $fields['response_by'] = Auth::id();

        $fields['status'] = 'Ongoing';
        
        $report = Report::create($fields);

        return view('report.qr', [
            'report_id' => $report->id,
            'qr_url' => route('report.complete', $report->id),
            'qrCode' => QrCode::size(200)->generate(route('report.complete', $report->id))
        ]);
    }

    public function complete($id)
    {
        $report = Report::findOrFail($id);
        
        if ($report->status === 'Ongoing') {
            $report->status = "Done";
            $report->feedback = "No";
            $report->remarks = "Emergency Report Completed via QR Code";
            $report->resolve_datetime = now();
            $report->save();

            $user['report_id'] = $report->id; 
            $user['user_id'] = $report->response_by;
            \App\Models\Resolve::create($user);
            
            return view('report.completed', ['report_id' => $report->id]);
        }
        
        return view('report.completed', ['report_id' => $report->id, 'error' => 'Report already completed']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        
       
        // if($request->iam_check){
            $report = Report::findOrFail($id);
            $report->response_by = $userId = Auth::id();

            // if($report->issues->mains->type == 'request'){
            //     $report->status = "Ongoing";
            // }
            // else{
                $report->status = "For validation";
            // }
            $report->notes = $request->notes;
            $report->response_datetime = Carbon::parse($request->response_datetime)->format('Y-m-d H:i:s');
            // $report->response_datetime = Carbon::now();
            $report->save();
            $report->logResponse();
            
            
        // }
        // else{
        //     $report = Report::findOrFail($id);
       
        //     $report->response_by = $request->user_id;
            
        //     $report->status = "For validation";
        //     $report->notes = $request->notes; 
        //     // $report->response_datetime = Carbon::now();
        //     $report->response_datetime = Carbon::parse($request->response_datetime)->format('Y-m-d H:i:s');
        //     $report->save();
        //     $report->logResponse();
        // }
        

        return redirect()->route('report.index')->with('success', 'Response sent successfully!');
    }

    public function resolve(Request $request, $id)
    {

      
        $validated = $request->validate([
            'user.*.user_id' => 'required',
            'procedure' => 'required',
            'completion_notes' => 'nullable',
            'resolve_datetime' => 'required',
        ]);
      
        //  dd($request->all());
        // Process or save the data
        foreach ($validated['user'] as $user) {
            // Example: save to the database
         
            $user['report_id'] = $id; 
            \App\Models\Resolve::create($user);
          
        }
       
        // return redirect()->back()->with('success', 'Data saved successfully!');
    
        $report = Report::findOrFail($id);
        // $report->resolve_id = $request->user_id;
        $report->status = "Done";
        $report->feedback = "No";
        $report->procedure = $request->procedure;
        $report->completion_notes = $request->completion_notes;
        $report->resolve_datetime = Carbon::parse($request->resolve_datetime)->format('Y-m-d H:i:s');
        $report->save();
        $report->logResolve();

        return redirect()->route('report.index')->with('success', 'Issue resolved successfully!');
    }

    public function escalate(Request $request, $id)
    {
       
 
        $report = Report::findOrFail($id);
        

        $report->escalated_to = $request->user_id;
        $report->status = "Done";
        $report->remarks = $request->remarks;
        $report->procedure = $request->procedure;
        // $report->resolve_datetime = Carbon::now();
        $report->resolve_datetime = Carbon::parse($request->resolve_datetime)->format('Y-m-d H:i:s');
        $report->save();

        $duplicateReport = $report->replicate();
        $duplicateReport->response_by = $request->user_id;
        $duplicateReport->status = "Ongoing";
        $duplicateReport->request_datetime = now();
        $duplicateReport->response_datetime = now();
        $duplicateReport->created_at = now();
        $duplicateReport->updated_at = now();
        $duplicateReport->save();
        return redirect()->route('report.index')->with('success', 'Issue escalated successfully!');
    }

    public function endorse(Request $request, $id)
    {
       
        
        $report = Report::findOrFail($id);
        

        // $report->escalated_to = $request->user_id;
        $report->status = "Void";
        $report->remarks = $request->remarks;
        // $report->procedure = $request->procedure;
        // $report->resolve_datetime = Carbon::now();
        $report->resolve_datetime = Carbon::parse($request->resolve_datetime)->format('Y-m-d H:i:s');
        $report->save();
        return redirect()->route('report.index')->with('success', 'Issue endorsed successfully!');
    }

    public function confirmValidate(Request $request)
    {
        $fields = $request->validate([
            'report_id' => 'required|integer',
            'validation_datetime' => 'required|date',
        ]);

        $report = Report::findOrFail($fields['report_id']);
        $report->validation_date_time = Carbon::parse($fields['validation_datetime'])->format('Y-m-d H:i:s');
        $report->status = "Ongoing";
        $report->validated_by = auth()->user()->id;
        $report->save();
        $report->logValidate();

        return redirect()->route('report.index')->with('success', 'Report validated successfully!');
    }

    public function changeIssue(Request $request)
    {
        $fields = $request->validate([
            'report_id' => 'required|integer',
            'validation_datetime' => 'nullable|date',
            'issues_id' => 'required|integer',
        ]);

        $report = Report::findOrFail($fields['report_id']);
        
        if (isset($fields['validation_datetime'])) {
            $report->validation_date_time = Carbon::parse($fields['validation_datetime'])->format('Y-m-d H:i:s');
        } else {
            $report->validation_date_time = now();
        }
        
        $report->issues_id = $fields['issues_id'];
        $report->status = "Ongoing";
        $report->save();
        $report->logValidate();

        return redirect()->route('report.index')->with('success', 'Issue changed successfully!');
    }

    public function validateReport(Request $request)
    {
        $fields = $request->validate([
            'id-issues' => 'required|integer',
            'validation_datetime' => 'nullable|date',
            'validation_status' => 'required|string',
            'issues_id' => 'required_if:validation_status,unresolved|nullable|integer',
        ]);

        $report = Report::findOrFail($fields['id-issues']);
        
        if (isset($fields['validation_datetime'])) {
            $report->validation_date_time = Carbon::parse($fields['validation_datetime'])->format('Y-m-d H:i:s');
        } else {
            $report->validation_date_time = now();
        }
        
        $report->status = "Ongoing";

        if ($fields['validation_status'] === 'unresolved' && isset($fields['issues_id'])) {
            $report->issues_id = $fields['issues_id'];
        }

        $report->save();
        $report->logValidate();

        return redirect()->route('report.index')->with('success', 'Report validated successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }

    public function export(Request $request)
    {
        return Excel::download(new ReportsExport($request->all()), 'reports.xlsx');
    }

    public function summary(Request $request)
    {
        $query = Report::whereIn('status', ['Done']);

        // Apply filters matching index and export
        if ($request->filled('date_from')) {
            $query->whereDate('resolve_datetime', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('resolve_datetime', '<=', $request->date_to);
        }
        
        if ($request->filled('department_id')) {
            $query->where('department_id', '=', $request->department_id);
        }
        
        if ($request->filled('category_id')) {
            $query->whereHas('Issues', function($q) use ($request) {
                $q->where('category_id', '=', $request->category_id);
            });
        }
        
        if ($request->filled('user_id')) {
            $query->whereHas('resolve', function($q) use ($request) {
                $q->where('user_id', '=', $request->user_id);
            });
        }

        $reports = $query->select([
            'id',
            'ticket_number',
            'request_datetime',
            'response_datetime',
            'validation_date_time',
            'resolve_datetime',
            'department_id',
            'issues_id'
        ])->get();

        $totalRequests = $reports->count();

        $responseTimes = [];
        $resolveTimes = [];
        $turnaroundTimes = [];

        foreach ($reports as $report) {
            // Response time (Waiting Time: request_datetime to response_datetime)
            if ($report->request_datetime && $report->response_datetime) {
                $req = Carbon::parse($report->request_datetime);
                $res = Carbon::parse($report->response_datetime);
                $diff = $req->diffInMinutes($res);
                $responseTimes[] = $diff;
            }

            // Resolution time: response/validation to resolve_datetime
            if ($report->resolve_datetime) {
                $startTime = $report->validation_date_time 
                    ? Carbon::parse($report->validation_date_time) 
                    : ($report->response_datetime ? Carbon::parse($report->response_datetime) : null);

                if ($startTime) {
                    $endTime = Carbon::parse($report->resolve_datetime);
                    $diff = $startTime->diffInMinutes($endTime);
                    $resolveTimes[] = $diff;
                }
            }

            // Turnaround time: request_datetime to resolve_datetime
            if ($report->request_datetime && $report->resolve_datetime) {
                $diff = Carbon::parse($report->request_datetime)->diffInMinutes(Carbon::parse($report->resolve_datetime));
                $turnaroundTimes[] = $diff;
            }
        }

        $formatDuration = function ($minutes) {
            if ($minutes === null) return 'N/A';
            $minutes = round($minutes);
            if ($minutes < 1) return '< 1 min';
            if ($minutes < 60) return $minutes . ' min' . ($minutes > 1 ? 's' : '');
            $hours = floor($minutes / 60);
            $rem = $minutes % 60;
            if ($rem === 0) return $hours . ' hr' . ($hours > 1 ? 's' : '');
            return $hours . ' hr' . ($hours > 1 ? 's ' : ' ') . $rem . ' min' . ($rem > 1 ? 's' : '');
        };

        $avgResponse = count($responseTimes) > 0 ? (array_sum($responseTimes) / count($responseTimes)) : null;
        $avgResolve = count($resolveTimes) > 0 ? (array_sum($resolveTimes) / count($resolveTimes)) : null;
        $avgTurnaround = count($turnaroundTimes) > 0 ? (array_sum($turnaroundTimes) / count($turnaroundTimes)) : null;

        $minResponse = count($responseTimes) > 0 ? min($responseTimes) : null;
        $maxResponse = count($responseTimes) > 0 ? max($responseTimes) : null;

        $within15 = count(array_filter($responseTimes, fn($m) => $m <= 15));
        $within60 = count(array_filter($responseTimes, fn($m) => $m <= 60));
        $over60 = count(array_filter($responseTimes, fn($m) => $m > 60));

        $totalWithResponse = count($responseTimes);

        // Filter labels
        $appliedFilters = [
            'date_range' => ($request->filled('date_from') || $request->filled('date_to'))
                ? (($request->filled('date_from') ? Carbon::parse($request->date_from)->format('M d, Y') : 'Start') . ' to ' . ($request->filled('date_to') ? Carbon::parse($request->date_to)->format('M d, Y') : 'End'))
                : 'All Dates',
            'department' => $request->filled('department_id') ? (Department::find($request->department_id)?->title ?? 'Selected') : 'All Departments',
            'category' => $request->filled('category_id') ? (Category::find($request->category_id)?->title ?? 'Selected') : 'All Categories',
            'staff' => $request->filled('user_id') ? (User::find($request->user_id)?->name ?? 'Selected') : 'All Staff',
        ];

        return response()->json([
            'success' => true,
            'total_requests' => $totalRequests,
            'total_requests_formatted' => number_format($totalRequests),
            'has_records' => $totalRequests > 0,
            'avg_response_time' => $formatDuration($avgResponse),
            'avg_response_minutes' => $avgResponse !== null ? round($avgResponse, 1) : null,
            'avg_resolve_time' => $formatDuration($avgResolve),
            'avg_resolve_minutes' => $avgResolve !== null ? round($avgResolve, 1) : null,
            'avg_turnaround_time' => $formatDuration($avgTurnaround),
            'avg_turnaround_minutes' => $avgTurnaround !== null ? round($avgTurnaround, 1) : null,
            'min_response_time' => $formatDuration($minResponse),
            'max_response_time' => $formatDuration($maxResponse),
            'within_15_mins' => $within15,
            'within_15_mins_pct' => $totalWithResponse > 0 ? round(($within15 / $totalWithResponse) * 100, 1) : 0,
            'within_1_hour' => $within60,
            'within_1_hour_pct' => $totalWithResponse > 0 ? round(($within60 / $totalWithResponse) * 100, 1) : 0,
            'over_1_hour' => $over60,
            'over_1_hour_pct' => $totalWithResponse > 0 ? round(($over60 / $totalWithResponse) * 100, 1) : 0,
            'filters' => $appliedFilters,
        ]);
    }

    public function logHistory($id)
    {
        $loghistories = History::where('report_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($loghistories as $log) {
            $log->perform_at = $log->created_at->format('M d, Y h:i A');
            $log->perform_by = $log->user->name ?? 'Unknown';
        }   

        return response()->json($loghistories);
    }


    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            // This will stream the upload straight to your Google Drive
            $path = Storage::disk('google')->putFile('uploaded_images', $file);

            return response()->json([
                'message' => 'Image uploaded successfully!',
                'path' => $path // Google Drive treats this path as a unique ID
            ]);
        }
    }

    public function showImage($filename)
    {
        // Check if file exists on Google Drive
        if (Storage::disk('google')->exists('uploaded_images/' . $filename)) {
            
            $file = Storage::disk('google')->get('uploaded_images/' . $filename);
            $type = Storage::disk('google')->mimeType('uploaded_images/' . $filename);

            return response($file, 200)->header('Content-Type', $type);
        }

        abort(404);
    }

    public function screenshot($id)
    {
        $report = Report::findOrFail($id);

        if (!$report->screenshot) {
            abort(404, 'No screenshot attached');
        }

        $path = $report->screenshot;

        try {
            if (Storage::disk('google')->exists($path)) {
                $file = Storage::disk('google')->get($path);
                $type = Storage::disk('google')->mimeType($path);
                return response($file, 200)->header('Content-Type', $type);
            }
        } catch (\Exception $e) {
            // Fallback to local storage checks below
        }

        if (Storage::disk('public')->exists($path)) {
            return response()->file(Storage::disk('public')->path($path));
        }

        if (Storage::disk('local')->exists($path)) {
            return response()->file(Storage::disk('local')->path($path));
        }

        if (file_exists(storage_path('app/' . $path))) {
            return response()->file(storage_path('app/' . $path));
        }

        if (file_exists(public_path($path))) {
            return response()->file(public_path($path));
        }

        abort(404, 'Screenshot file not found');
    }
}
