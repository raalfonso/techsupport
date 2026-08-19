<?php

namespace App\Http\Controllers;

use App\Models\AuthAssignment;
use App\Models\AuthItem;
use App\Models\User;
use Illuminate\Http\Request;

class AuthAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = AuthAssignment::with(['user', 'authItem']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', '%' . $search . '%')
                       ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhere('item_name', 'like', '%' . $search . '%');
            });
        }

        $assignments = $query->paginate(10)->appends(['search' => $search]);
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
