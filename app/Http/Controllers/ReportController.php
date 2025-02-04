<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Resolve;
use App\Models\Category;
use App\Models\Department;
use App\Models\Issues;
use App\Models\User;
use App\Models\Clients;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $reports = Report::whereIn('status', ['Pending', 'Ongoing'])
        ->orderBy('id', 'asc')
        ->paginate(5);

        $countReport = Report::whereIn('status', ['Pending', 'Ongoing'])->count();

        $user_level = auth()->user()->level;
        $user_team = auth()->user()->team;
        $user_id = auth()->user()->id;
       
        if ($user_level == 1) {
            $resolved = Report::whereIn('status', ['Done'])
            ->orderBy('id', 'asc')
            ->paginate(5);
           
        }
        else {
            // $resolved = Resolve::select('reports.*', 'users.name','clients.name as client','departments.title as department')
            // ->leftJoin('reports', 'resolve.report_id', '=', 'reports.id')
            // ->leftJoin('users', 'users.id', '=', 'resolve.user_id')
            // ->leftJoin('clients', 'clients.id', '=', 'reports.client_id')
            // ->leftJoin('departments', 'departments.id', '=', 'reports.department_id')
            // ->get();

            // $resolved = Report::select('reports.*', 'users.name as user')
            // ->rightJoin('resolve', 'resolve.report_id','=','reports.id')
            // ->leftJoin('users', 'resolve.user_id','=','users.id')
            // ->where('reports.status', 'Done')
            // ->get();
            $resolved = Report::whereIn('status', ['Done'])
            ->orderBy('id', 'asc')
            ->paginate(5);
        }
        
        $clients = Clients::orderBy('name','asc')->get();

     


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
            'clients' => $clients,
        ]);
    }

    public function getReports()
    {
        $reports = Report::whereIn('status', ['Pending', 'Ongoing'])
        ->orderBy('id', 'asc')
        ->paginate(5);
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
        $countReport = Report::whereIn('status', ['Pending', 'Ongoing'])->count();

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
        $fields = $request->validate([
            'client_id' => 'required',
            'department_id' => 'required',
            'issues_id' => 'required',
        ]);

    
        Report::create($fields);

        //Redirect
      return redirect()->route('report.index');
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
            $report->status = "Ongoing";
            $report->notes = $request->notes;
            $report->response_datetime = Carbon::now();
            $report->save();
        }
        else{
            $report = Report::findOrFail($id);
       
            $report->response_by = $request->user_id;
            $report->status = "Ongoing";
            $report->notes = $request->notes;
            $report->response_datetime = Carbon::now();
            $report->save();
        }
        

        return redirect()->route('report.index');
    }

    public function resolve(Request $request, $id)
    {

      
        $validated = $request->validate([
            'user.*.user_id' => 'required',
            'procedure' => 'required',
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
        $report->resolve_datetime = Carbon::now();
        $report->save();

        return redirect()->route('report.index');
    }

    public function escalate(Request $request, $id)
    {
       
 
        $report = Report::findOrFail($id);
        

        $report->escalated_to = $request->user_id;
        $report->status = "Done";
        $report->remarks = $request->remarks;
        $report->procedure = $request->procedure;
        $report->resolve_datetime = Carbon::now();
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
}
