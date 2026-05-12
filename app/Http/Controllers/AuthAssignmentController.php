<?php

namespace App\Http\Controllers;

use App\Models\AuthAssignment;
use App\Models\AuthItem;
use App\Models\User;
use Illuminate\Http\Request;

class AuthAssignmentController extends Controller
{
    public function index()
    {
        $assignments = AuthAssignment::with(['user', 'authItem'])->paginate(10);
        $users = User::all();
        $authItems = AuthItem::all();
        return view('auth-assignment.index', compact('assignments', 'users', 'authItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_name' => 'required|exists:auth_item,name'
        ]);

        AuthAssignment::create($request->all());
        return redirect()->route('auth-assignment.index')->with('success', 'Assignment created successfully');
    }

    public function update(Request $request, AuthAssignment $authAssignment)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_name' => 'required|exists:auth_item,name'
        ]);

        $authAssignment->update($request->all());
        return redirect()->route('auth-assignment.index')->with('success', 'Assignment updated successfully');
    }

    public function destroy(AuthAssignment $authAssignment)
    {
        $authAssignment->delete();
        return redirect()->route('auth-assignment.index')->with('success', 'Assignment deleted successfully');
    }
}
