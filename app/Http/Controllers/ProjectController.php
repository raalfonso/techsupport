<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMember;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Requested,Pending,For Evaluation,Data Gathering,On Hold,Development,Testing,User Acceptance Training,Deployed,For Enhancement'
        ]);

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('devwatch.index')->with('success', 'Project updated successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Requested,Pending,For Evaluation,Data Gathering,On Hold,Development,Testing,User Acceptance Training,Deployed,For Enhancement'
        ]);

        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => auth()->id()
        ]);
        
        return redirect()->route('devwatch.index')->with('success', 'Project created successfully!');
    }

    public function addMember(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:member,lead,manager'
        ]);

        ProjectMember::updateOrCreate(
            [
                'project_id' => $request->project_id,
                'user_id' => $request->user_id
            ],
            ['role' => $request->role]
        );
        
        return redirect()->route('devwatch.index')->with('success', 'Member added successfully!');
    }
}