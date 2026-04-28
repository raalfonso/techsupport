<?php

namespace App\Http\Controllers;

use App\Models\MeetingDetail;
use App\Models\MeetingType;
use App\Models\Agenda;
use App\Models\MeetingTask;
use Illuminate\Http\Request;

class MeetingDetailController extends Controller
{
    public function index()
    {
        $meetings = MeetingDetail::with(['type', 'agendas', 'tasks'])
            ->latest()
            ->paginate(20);
        
        return view('keyboard.meetings.index', compact('meetings'));
    }

    public function create()
    {
        $meetingTypes = MeetingType::where('is_active', true)->get();
        return view('keyboard.meetings.create', compact('meetingTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'venue' => 'nullable|string',
            'type_id' => 'nullable|exists:meeting_types,id',
            'agendas' => 'nullable|array',
            'agendas.*.title' => 'required|string',
            'agendas.*.details' => 'nullable|string',
            'agendas.*.assigned_personnel' => 'nullable|string',
            'agendas.*.remarks' => 'nullable|string',
            'tasks' => 'nullable|array',
            'tasks.*.title' => 'required|string',
            'tasks.*.details' => 'nullable|string',
            'tasks.*.assigned_personnel' => 'nullable|string',
            'tasks.*.remarks' => 'nullable|string',
        ]);

        $meeting = MeetingDetail::create([
            'title' => $validated['title'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'venue' => $validated['venue'] ?? null,
            'type_id' => $validated['type_id'] ?? null,
        ]);

        // Create agendas
        if (isset($validated['agendas'])) {
            foreach ($validated['agendas'] as $agendaData) {
                $meeting->agendas()->create([
                    'title' => $agendaData['title'],
                    'details' => $agendaData['details'] ?? null,
                    'assigned_personnel' => $agendaData['assigned_personnel'] ?? null,
                    'remarks' => $agendaData['remarks'] ?? null,
                    'status' => 'Pending',
                ]);
            }
        }

        // Create tasks
        if (isset($validated['tasks'])) {
            foreach ($validated['tasks'] as $taskData) {
                $meeting->tasks()->create([
                    'title' => $taskData['title'],
                    'details' => $taskData['details'] ?? null,
                    'assigned_personnel' => $taskData['assigned_personnel'] ?? null,
                    'remarks' => $taskData['remarks'] ?? null,
                    'status' => 'Pending',
                ]);
            }
        }

        return redirect()->route('keyboard.index')->with('success', 'Meeting created successfully');
    }

    public function show(MeetingDetail $meetingDetail)
    {
        $meetingDetail->load(['type', 'agendas', 'tasks']);
        return view('keyboard.meetings.show', compact('meetingDetail'));
    }

    public function edit(MeetingDetail $meetingDetail)
    {
        $meetingTypes = MeetingType::where('is_active', true)->get();
        $meetingDetail->load(['agendas', 'tasks']);
        return view('keyboard.meetings.edit', compact('meetingDetail', 'meetingTypes'));
    }

    public function update(Request $request, MeetingDetail $meetingDetail)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'venue' => 'nullable|string',
            'type_id' => 'nullable|exists:meeting_types,id',
        ]);

        $meetingDetail->update($validated);

        return redirect()->route('keyboard.index')->with('success', 'Meeting updated successfully');
    }

    public function destroy(MeetingDetail $meetingDetail)
    {
        $meetingDetail->delete();
        return redirect()->route('keyboard.index')->with('success', 'Meeting deleted successfully');
    }

    public function createFollowUp(MeetingDetail $meetingDetail)
    {
        $meetingTypes = MeetingType::where('is_active', true)->get();
        
        // Get incomplete tasks and agendas
        $incompleteTasks = $meetingDetail->tasks()->whereIn('status', ['Pending', 'In Process'])->get();
        $incompleteAgendas = $meetingDetail->agendas()->whereIn('status', ['Pending', 'In Process'])->get();
        
        return view('keyboard.meetings.create-followup', compact('meetingDetail', 'meetingTypes', 'incompleteTasks', 'incompleteAgendas'));
    }

    public function present(MeetingDetail $meetingDetail)
    {
        $meetingDetail->load(['type', 'agendas.updatedByUser', 'tasks.updatedByUser']);
        return view('keyboard.meetings.present', compact('meetingDetail'));
    }

    // Agenda management
    public function storeAgenda(Request $request, MeetingDetail $meetingDetail)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'details' => 'nullable|string',
            'assigned_personnel' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $meetingDetail->agendas()->create(array_merge($validated, ['status' => 'Pending']));

        return back()->with('success', 'Agenda added successfully');
    }

    public function updateAgenda(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'details' => 'nullable|string',
            'assigned_personnel' => 'nullable|string',
            'remarks' => 'nullable|string',
            'status' => 'required|in:Pending,In Process,Done',
        ]);

        $agenda->update($validated);

        return back()->with('success', 'Agenda updated successfully');
    }

    public function destroyAgenda(Agenda $agenda)
    {
        $agenda->delete();
        return back()->with('success', 'Agenda deleted successfully');
    }

    // Task management
    public function storeTask(Request $request, MeetingDetail $meetingDetail)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'details' => 'nullable|string',
            'assigned_personnel' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $meetingDetail->tasks()->create(array_merge($validated, ['status' => 'Pending']));

        return back()->with('success', 'Task added successfully');
    }

    public function updateTask(Request $request, MeetingTask $task)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'details' => 'nullable|string',
            'assigned_personnel' => 'nullable|string',
            'remarks' => 'nullable|string',
            'status' => 'required|in:Pending,In Process,Done',
        ]);

        $task->update($validated);

        return back()->with('success', 'Task updated successfully');
    }

    public function destroyTask(MeetingTask $task)
    {
        $task->delete();
        return back()->with('success', 'Task deleted successfully');
    }
}
