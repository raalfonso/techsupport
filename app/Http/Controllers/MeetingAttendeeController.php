<?php

namespace App\Http\Controllers;

use App\Models\MeetingAttendee;
use App\Models\MeetingDetail;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingAttendeeController extends Controller
{
    public function index()
    {
        $attendees = MeetingAttendee::with(['attendee', 'meetingDetail'])
            ->latest()
            ->paginate(20);
        
        return view('meeting-attendees.index', compact('attendees'));
    }

    public function create()
    {
        $meetings = MeetingDetail::orderBy('date', 'desc')->get();
        $users = User::orderBy('name')->get();
        return view('meeting-attendees.create', compact('meetings', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'meeting_detail_id' => 'required|exists:meeting_details,id',
            'attendee_id' => 'required|exists:users,id',
        ]);

        // Check if attendee is already added to this meeting
        $existingAttendee = MeetingAttendee::where('meeting_detail_id', $validated['meeting_detail_id'])
            ->where('attendee_id', $validated['attendee_id'])
            ->first();

        if ($existingAttendee) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Attendee is already added to this meeting'
                ], 422);
            }
            return redirect()->back()->with('error', 'Attendee is already added to this meeting');
        }

        MeetingAttendee::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Attendee added successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Attendee added successfully');
    }

    public function show(MeetingAttendee $meetingAttendee)
    {
        $meetingAttendee->load(['attendee', 'meetingDetail']);
        return view('meeting-attendees.show', compact('meetingAttendee'));
    }

    public function edit(MeetingAttendee $meetingAttendee)
    {
        $meetings = MeetingDetail::orderBy('date', 'desc')->get();
        $users = User::orderBy('name')->get();
        return view('meeting-attendees.edit', compact('meetingAttendee', 'meetings', 'users'));
    }

    public function update(Request $request, MeetingAttendee $meetingAttendee)
    {
        $validated = $request->validate([
            'meeting_detail_id' => 'required|exists:meeting_details,id',
            'attendee_id' => 'required|exists:users,id',
        ]);

        $meetingAttendee->update($validated);

        return redirect()->back()->with('success', 'Attendee updated successfully');
    }

    public function destroy(MeetingAttendee $meetingAttendee)
    {
        $meetingAttendee->delete();
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Attendee removed successfully'
            ]);
        }
        
        return redirect()->back()->with('success', 'Attendee removed successfully');
    }
}
