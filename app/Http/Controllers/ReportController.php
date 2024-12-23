<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Category;
use App\Models\Department;
use App\Models\Issues;
use App\Models\User;
use Carbon\Carbon;
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
        ]);
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
            'requestor_name' => ['required','string','max:50'],
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
 
        $report = Report::findOrFail($id);
       
        $report->user_id = $request->user_id;
        $report->status = "Ongoing";
        $report->response_datetime = Carbon::now();
        $report->save();

        return redirect()->route('report.index');
    }

    public function resolve(Request $request, $id)
    {
       
 
        $report = Report::findOrFail($id);
       
        $report->user_id = $request->user_id;
        $report->status = "Done";
        $report->procedure = $request->procedure;
        $report->resolve_datetime = Carbon::now();
        $report->save();

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
