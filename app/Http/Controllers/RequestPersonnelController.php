<?php

namespace App\Http\Controllers;

use App\Models\RequestPersonnel;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\Request;

class RequestPersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Check if user is Administrator or IT_User
        $isAdminOrIT = $user->authAssignments()
            ->whereIn('item_name', ['Administrator', 'IT_User'])
            ->exists();
        
        $query = RequestPersonnel::with(['requestor', 'resources']);
        
        // If not admin or IT user, only show their own requests
        if (!$isAdminOrIT) {
            $query->where('requestor_id', $user->id);
        }
        
        $requestPersonnel = $query->paginate(15);
        
        return view('request_personnel.index', compact('requestPersonnel'));
    }

    /**
     * Display approval page for administrators.
     */
    public function approval()
    {
        // Check if user is Administrator
        $isAdmin = auth()->user()->authAssignments()
            ->where('item_name', 'Administrator')
            ->exists();
        
        if (!$isAdmin) {
            abort(403, 'Unauthorized access.');
        }
        
        // Get all requests with pending status
        $requestPersonnel = RequestPersonnel::with(['requestor', 'resources'])
            ->whereIn('status', ['pending', 'approved', 'rejected'])
            ->latest()
            ->paginate(15);
        
        return view('request_personnel.approval', compact('requestPersonnel'));
    }

    /**
     * Display approval detail page for a specific request.
     */
    public function approvalShow(RequestPersonnel $requestPersonnel)
    {
        // Check if user is Administrator
        $isAdmin = auth()->user()->authAssignments()
            ->where('item_name', 'Administrator')
            ->exists();
        
        if (!$isAdmin) {
            abort(403, 'Unauthorized access.');
        }
        
        // Load relationships
        $requestPersonnel->load(['requestor', 'resources', 'assignedStaff']);
        
        // Get all users for staff assignment
        $users = User::where('level',[1,2])->orderBy('name')->get();
        
        return view('request_personnel.approval_show', compact('requestPersonnel', 'users'));
    }

    /**
     * Assign staff to a request.
     */
    public function assignStaff(Request $request, RequestPersonnel $requestPersonnel)
    {
        // Check if user is Administrator
        $isAdmin = auth()->user()->authAssignments()
            ->where('item_name', 'Administrator')
            ->exists();
        
        if (!$isAdmin) {
            abort(403, 'Unauthorized access.');
        }
        
        $validated = $request->validate([
            'staff' => 'nullable|array',
            'staff.*' => 'exists:users,id',
        ]);
        
        // Sync assigned staff
        if ($request->has('staff')) {
            $requestPersonnel->assignedStaff()->sync($request->staff);
        } else {
            $requestPersonnel->assignedStaff()->detach();
        }
        
        return redirect()->back()->with('success', 'Staff assigned successfully.');
    }

    /**
     * Update the status of a request.
     */
    public function updateStatus(Request $request, RequestPersonnel $requestPersonnel)
    {
        // Check if user is Administrator
        $isAdmin = auth()->user()->authAssignments()
            ->where('item_name', 'Administrator')
            ->exists();
        
        if (!$isAdmin) {
            abort(403, 'Unauthorized access.');
        }
        
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed,cancelled',
        ]);
        
        $requestPersonnel->update(['status' => $validated['status']]);
        
        return redirect()->back()->with('success', 'Request status updated successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $resources = Resource::where('is_active', true)->orderBy('item_name')->get();
        return view('request_personnel.create', compact('users', 'resources'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_title' => 'required|string|max:255',
            'requestor_id' => 'required|exists:users,id',
            'start_date_time' => 'required|date_format:Y-m-d\TH:i',
            'end_date_time' => 'required|date_format:Y-m-d\TH:i|after:start_date_time',
            'point_person' => 'nullable|string|max:100',
            'meeting_link' => 'nullable|url',
            'status' => 'required|in:pending,approved,rejected,completed,cancelled',
            'resources' => 'nullable|array',
            'resources.*' => 'exists:resources,id',
        ]);

        $requestPersonnel = RequestPersonnel::create($validated);

        // Attach selected resources
        if ($request->has('resources')) {
            $requestPersonnel->resources()->attach($request->resources);
        }

        return redirect()->route('request-personnel.index')
            ->with('success', 'Request created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestPersonnel $requestPersonnel)
    {
        // Load relationships including assigned staff
        $requestPersonnel->load(['requestor', 'resources', 'assignedStaff']);
        
        return view('request_personnel.show', compact('requestPersonnel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestPersonnel $requestPersonnel)
    {
        $users = User::all();
        $resources = Resource::where('is_active', true)->orderBy('item_name')->get();
        return view('request_personnel.edit', compact('requestPersonnel', 'users', 'resources'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestPersonnel $requestPersonnel)
    {
        $validated = $request->validate([
            'event_title' => 'required|string|max:255',
            'requestor_id' => 'required|exists:users,id',
            'start_date_time' => 'required|date_format:Y-m-d\TH:i',
            'end_date_time' => 'required|date_format:Y-m-d\TH:i|after:start_date_time',
            'point_person' => 'nullable|string|max:100',
            'meeting_link' => 'nullable|url',
            'status' => 'required|in:pending,approved,rejected,completed,cancelled',
            'resources' => 'nullable|array',
            'resources.*' => 'exists:resources,id',
        ]);

        $requestPersonnel->update($validated);

        // Sync selected resources
        if ($request->has('resources')) {
            $requestPersonnel->resources()->sync($request->resources);
        } else {
            $requestPersonnel->resources()->detach();
        }

        return redirect()->route('request-personnel.show', $requestPersonnel)
            ->with('success', 'Request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestPersonnel $requestPersonnel)
    {
        // Instead of deleting, change status to cancelled
        $requestPersonnel->update(['status' => 'cancelled']);

        return redirect()->route('request-personnel.index')
            ->with('success', 'Request cancelled successfully.');
    }
}
