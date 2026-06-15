<?php

namespace App\Http\Controllers;

use App\Models\DevWatch;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class DevWatchController extends Controller
{
    public function index()
    {
        $items = DevWatch::with('user')->orderBy('created_at', 'desc')->get();
        $projects = Project::with(['user', 'members.user'])->orderBy('created_at', 'desc')->get();
        $users = User::all();
        return view('devwatch.index', compact('items', 'projects', 'users'));
    }

    public function create()
    {
        return view('devwatch.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'type' => 'required|in:Bugs,Improvement,New Feature',
            'remarks' => 'nullable|string',
            'requestor_name' => 'nullable|string|max:255',
            'reported_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        DevWatch::create([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
            'type' => $request->type,
            'remarks' => $request->remarks,
            'requestor_name' => $request->requestor_name,
            'reported_date' => $request->reported_date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => auth()->id()
        ]);
        
        return redirect()->route('devwatch.index')->with('success', 'DevWatch item created successfully!');
    }

    public function edit(DevWatch $devwatch)
    {
        return view('devwatch.edit', compact('devwatch'));
    }

    public function update(Request $request, DevWatch $devwatch)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'remarks' => 'nullable|string',
            'requestor_name' => 'nullable|string|max:255',
            'reported_date' => 'nullable|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $devwatch->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
            'remarks' => $request->remarks,
            'requestor_name' => $request->requestor_name,
            'reported_date' => $request->reported_date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        
        return redirect()->route('devwatch.index')->with('success', 'DevWatch item updated successfully!');
    }

    public function destroy(DevWatch $devwatch)
    {
        $devwatch->delete();
        return redirect()->route('devwatch.index')->with('success', 'DevWatch item deleted successfully!');
    }
}