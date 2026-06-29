<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportRequestController extends Controller
{
    private function isAdmin(): bool
    {
        return Auth::user()?->authAssignments()
            ->whereIn('item_name', ['Administrator', 'IT_User'])
            ->exists() ?? false;
    }

    public function index()
    {
        $query = SupportRequest::with(['requester', 'assignedIt'])->latest();

        if (! $this->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $supportRequests = $query->paginate(10);

        return view('support_requests.index', compact('supportRequests'));
    }

    public function create()
    {
        return view('support_requests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_title' => ['required', 'string', 'max:255'],
            'start_datetime' => ['required', 'date'],
            'end_datetime' => ['required', 'date', 'after:start_datetime'],
            'support_details' => ['required', 'string'],
            'meeting_link' => ['nullable', 'url', 'max:255'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        SupportRequest::create($validated);

        return redirect()->route('support-requests.index')->with('success', 'Support request submitted successfully.');
    }

    public function show(SupportRequest $supportRequest)
    {
        $supportRequest->load(['requester', 'approver', 'assignedIt']);

        return view('support_requests.show', compact('supportRequest'));
    }

    public function edit(SupportRequest $supportRequest)
    {
        return view('support_requests.edit', compact('supportRequest'));
    }

    public function update(Request $request, SupportRequest $supportRequest)
    {
        $validated = $request->validate([
            'event_title' => ['required', 'string', 'max:255'],
            'start_datetime' => ['required', 'date'],
            'end_datetime' => ['required', 'date', 'after:start_datetime'],
            'support_details' => ['required', 'string'],
            'meeting_link' => ['nullable', 'url', 'max:255'],
        ]);

        $supportRequest->update($validated);

        return redirect()->route('support-requests.index')->with('success', 'Support request updated successfully.');
    }

    public function destroy(SupportRequest $supportRequest)
    {
        $supportRequest->update(['status' => 'cancelled']);

        return redirect()->route('support-requests.index')->with('success', 'Support request cancelled successfully.');
    }

    public function approval()
    {
        $supportRequests = SupportRequest::with(['requester', 'assignedIt'])
            ->latest()
            ->paginate(10);

        return view('support_requests.approval', compact('supportRequests'));
    }

    public function approvalShow(SupportRequest $supportRequest)
    {
        $supportRequest->load(['requester', 'approver', 'assignedIt']);

        $users = User::whereHas('authAssignments', function ($query) {
                $query->whereIn('item_name', ['Administrator', 'IT_User']);
            })
            ->orderBy('name')
            ->get();

        return view('support_requests.approval_show', compact('supportRequest', 'users'));
    }

    public function updateStatus(Request $request, SupportRequest $supportRequest)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected,assigned,in_progress,completed,cancelled'],
            'approver_remarks' => ['nullable', 'string'],
        ]);

        if (in_array($validated['status'], ['approved', 'rejected'])) {
            $validated['approved_by'] = Auth::id();
        }

        $supportRequest->update($validated);

        return back()->with('success', 'Request status updated successfully.');
    }

    public function assignStaff(Request $request, SupportRequest $supportRequest)
    {
        $validated = $request->validate([
            'assigned_it_id' => ['required', 'exists:users,id'],
            'approver_remarks' => ['nullable', 'string'],
        ]);

        $supportRequest->update([
            'assigned_it_id' => $validated['assigned_it_id'],
            'approver_remarks' => $validated['approver_remarks'] ?? $supportRequest->approver_remarks,
            'status' => 'assigned',
            'approved_by' => $supportRequest->approved_by ?? Auth::id(),
        ]);

        return back()->with('success', 'IT personnel assigned successfully.');
    }
}
