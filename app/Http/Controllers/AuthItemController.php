<?php

namespace App\Http\Controllers;

use App\Models\AuthItem;
use Illuminate\Http\Request;

class AuthItemController extends Controller
{
    public function index()
    {
        $authItems = AuthItem::paginate(10);
        return view('auth.index', compact('authItems'));
    }

    public function create()
    {
        return view('auth.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:auth_item',
            'type' => 'required',
            'description' => 'nullable'
        ]);

        AuthItem::create($request->all());
        return redirect()->route('auth.index')->with('success', 'Auth item created successfully');
    }

    public function edit(AuthItem $auth)
    {
        return view('auth.edit', compact('auth'));
    }

    public function update(Request $request, AuthItem $auth)
    {
        $request->validate([
            'name' => 'required|unique:auth_item,name,' . $auth->id,
            'type' => 'required',
            'description' => 'nullable'
        ]);

        $auth->update($request->all());
        return redirect()->route('auth.index')->with('success', 'Auth item updated successfully');
    }

    public function destroy(AuthItem $auth)
    {
        $auth->delete();
        return redirect()->route('auth.index')->with('success', 'Auth item deleted successfully');
    }
}
