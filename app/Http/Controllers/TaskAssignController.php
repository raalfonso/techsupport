<?php

namespace App\Http\Controllers;

use App\Models\TaskAssign;
use App\Models\MeetingTask;
use App\Models\User;
use Illuminate\Http\Request;

class TaskAssignController extends Controller
{
    public function index()
    {
        $taskAssigns = TaskAssign::with(['meetingTask.meetingDetail', 'assignedPersonnel'])
            ->latest()
            ->paginate(20);
        
        return view('task-assigns.index', compact('taskAssigns'));
    }

    public function create(MeetingTask $task)
    {
        $users = User::orderBy('name')->get();
        return view('task-assigns.create', compact('task', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'meeting_task_id' => 'required|exists:meeting_tasks,id',
            'assigned_personnel_id' => 'required|exists:users,id',
            'status' => 'nullable|in:Pending,In Process,Done',
        ]);

        $validated['status'] = $validated['status'] ?? 'Pending';

        TaskAssign::create($validated);

        return redirect()->back()->with('success', 'Task assigned successfully');
    }

    public function show(TaskAssign $taskAssign)
    {
        $taskAssign->load(['meetingTask.meetingDetail', 'assignedPersonnel']);
        return view('task-assigns.show', compact('taskAssign'));
    }

    public function edit(TaskAssign $taskAssign)
    {
        $users = User::orderBy('name')->get();
        return view('task-assigns.edit', compact('taskAssign', 'users'));
    }

    public function update(Request $request, TaskAssign $taskAssign)
    {
        $validated = $request->validate([
            'assigned_personnel_id' => 'required|exists:users,id',
            'status' => 'required|in:Pending,In Process,Done',
        ]);

        $taskAssign->update($validated);

        return redirect()->back()->with('success', 'Task assignment updated successfully');
    }

    public function destroy(TaskAssign $taskAssign)
    {
        $taskAssign->delete();
        return redirect()->back()->with('success', 'Task assignment deleted successfully');
    }

    public function updateStatus(Request $request, TaskAssign $taskAssign)
    {
        // Check if the current user is the assigned personnel
        if (auth()->id() !== $taskAssign->assigned_personnel_id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this assignment status.'
            ], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:Pending,In Process,Done',
            'remarks' => 'nullable|string',
        ]);

        $taskAssign->update($validated);

        return response()->json(['success' => true]);
    }
}
