<?php

namespace App\Http\Controllers;

use App\Models\MeetingDetail;
use App\Models\MeetingType;
use App\Models\Agenda;
use App\Models\MeetingTask;
use Illuminate\Http\Request;

class KeyBoardController extends Controller
{
    public function index()
    {
        $meetings = MeetingDetail::with(['type', 'agendas.updatedByUser', 'tasks.updatedByUser'])
            ->orderBy('date', 'desc')
            ->get();

        $meetingTypes = MeetingType::where('is_active', true)->get();

        return view('keyboard.index', compact('meetings', 'meetingTypes'));
    }

    public function calendar()
    {
        $meetings = MeetingDetail::with(['type', 'agendas', 'tasks'])
            ->orderBy('date', 'asc')
            ->get();

        return view('keyboard.calendar', compact('meetings'));
    }

    public function archive()
    {
        $meetings = MeetingDetail::with(['type', 'agendas', 'tasks'])
            ->where('date', '<', now())
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('keyboard.archive', compact('meetings'));
    }

    public function settings()
    {
        $meetingTypes = MeetingType::orderBy('title')->get();
        return view('keyboard.settings', compact('meetingTypes'));
    }

    public function storeType(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        MeetingType::create(array_merge($validated, ['is_active' => true]));

        return back()->with('success', 'Meeting type created successfully');
    }

    public function updateType(Request $request, MeetingType $type)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $type->update($validated);

        return back()->with('success', 'Meeting type updated successfully');
    }

    public function destroyType(MeetingType $type)
    {
        $type->delete();
        return back()->with('success', 'Meeting type deleted successfully');
    }

    public function updateAgendaStatus(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,In Process,Done',
            'remarks' => 'nullable|string',
        ]);

        $validated['updated_by'] = auth()->id();
        
        $agenda->update($validated);
        
        return response()->json(['success' => true]);
    }

    public function updateTaskStatus(Request $request, MeetingTask $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,In Process,Done',
            'remarks' => 'nullable|string',
        ]);

        $validated['updated_by'] = auth()->id();
        
        $task->update($validated);
        
        return response()->json(['success' => true]);
    }
}
