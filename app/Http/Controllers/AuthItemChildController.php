<?php

namespace App\Http\Controllers;

use App\Models\AuthItem;
use App\Models\AuthItemChild;
use Illuminate\Http\Request;

class AuthItemChildController extends Controller
{
    public function index()
    {
        $authItemChildren = AuthItemChild::with(['parentItem', 'childItem'])->paginate(10);
        $authItems = AuthItem::all();
        return view('auth-child.index', compact('authItemChildren', 'authItems'));
    }

    public function create()
    {
        $authItems = AuthItem::all();
        return view('auth-child.create', compact('authItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent' => 'required|exists:auth_item,name',
            'child' => 'required|exists:auth_item,name|different:parent'
        ]);

        AuthItemChild::create($request->all());
        return redirect()->route('auth-child.index')->with('success', 'Auth item child created successfully');
    }

    public function edit(AuthItemChild $authChild)
    {
        $authItems = AuthItem::all();
        return view('auth-child.edit', compact('authChild', 'authItems'));
    }

    public function update(Request $request, AuthItemChild $authChild)
    {
        $request->validate([
            'parent' => 'required|exists:auth_item,name',
            'child' => 'required|exists:auth_item,name|different:parent'
        ]);

        $authChild->update($request->all());
        return redirect()->route('auth-child.index')->with('success', 'Auth item child updated successfully');
    }

    public function destroy(AuthItemChild $authChild)
    {
        $authChild->delete();
        return redirect()->route('auth-child.index')->with('success', 'Auth item child deleted successfully');
    }
}
