<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $query = Resource::query();

        if ($request->has('search') && $request->search) {
            $query->where('item_name', 'like', "%{$request->search}%");
        }

        $sort = $request->get('sort', 'latest');
        if ($sort === 'oldest') {
            $query->oldest('created_at');
        } else {
            $query->latest('created_at');
        }

        $resources = $query->paginate(15);

        return view('resources.index', compact('resources'));
    }

    public function create()
    {
        return view('resources.create');
    }

    public function store(Request $request)
    {
        
        $fields = $request->validate([
            'item_name' => ['required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    
        $fields['is_active'] = $request->boolean('is_active');
        $fields['created_by'] = auth()->id();
        $fields['created_at'] = now();

        Resource::create($fields);

        return redirect()->route('resources.index')->with('success', 'Resource created successfully!');
    }

    public function edit(Resource $resource)
    {
        return view('resources.edit', compact('resource'));
    }

    public function update(Request $request, Resource $resource)
    {
        $fields = $request->validate([
            'item_name' => ['required', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $fields['is_active'] = $request->boolean('is_active');

        $resource->update($fields);

        return redirect()->route('resources.index')->with('success', 'Resource updated successfully!');
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect()->route('resources.index')->with('success', 'Resource deleted successfully!');
    }
}
