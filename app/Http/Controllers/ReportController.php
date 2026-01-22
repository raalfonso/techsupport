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
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
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
     
        //Redirect
      return redirect()->route('report.index');
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
        //  dd($request->notes);
        if($request->iam_check == 'on'){
            $report = Report::findOrFail($id);
            $report->response_by = $userId = Auth::id();

            if($report->issues->mains->type == 'request'){
                $report->status = "Ongoing";
            }
            else{
                $report->status = "For validation";
            }
            $report->notes = $request->notes;
            $report->response_datetime = Carbon::parse($request->response_datetime)->format('Y-m-d H:i:s');
            // $report->response_datetime = Carbon::now();
            $report->save();
            $report->logResponse();
            
            
        }
        else{
            $report = Report::findOrFail($id);
       
            $report->response_by = $request->user_id;
            $report->status = "For validation";
            $report->notes = $request->notes;
            // $report->response_datetime = Carbon::now();
            $report->response_datetime = Carbon::parse($request->response_datetime)->format('Y-m-d H:i:s');
            $report->save();
            $report->logResponse();
        }
        

        return redirect()->route('report.index');
    }

    public function resolve(Request $request, $id)
    {

      
        $validated = $request->validate([
            'user.*.user_id' => 'required',
            'procedure' => 'required',
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
        $report->resolve_datetime = Carbon::parse($request->resolve_datetime)->format('Y-m-d H:i:s');
        $report->save();
        $report->logResolve();

        return redirect()->route('report.index');
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
        return redirect()->route('report.index');
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
        return redirect()->route('report.index');
    }

    public function validateReport(Request $request)
    {
        $fields = $request->validate([
            'id-issues' => 'required|integer',
            'validation_datetime' => 'required|date',
            'validation_status' => 'required|string',
            'issues_id' => 'nullable|integer',
        ]);

        $report = Report::findOrFail($fields['id-issues']);
        $report->validation_date_time = Carbon::parse($fields['validation_datetime'])->format('Y-m-d H:i:s');
        $report->status = "Ongoing";

        if ($fields['validation_status'] !== 'confirm') {
            // Only update issues_id when validation is not "confirm"
            $report->issues_id = $fields['issues_id'];
        }

        $report->save();
        $report->logValidate();

        return redirect()
                ->route('report.index')
                ->with('success', 'Report has been successfully validated.');
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
}
