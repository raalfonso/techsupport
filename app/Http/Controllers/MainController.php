<?php

namespace App\Http\Controllers;

use App\Models\Main;
use App\Http\Requests\StoreMainRequest;
use App\Http\Requests\UpdateMainRequest;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Main::query();

        // Search by title
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%')
                  ->orWhere('details', 'like', '%' . request('search') . '%');
        }

        // Filter by type
        if (request('type')) {
            $query->where('type', request('type'));
        }

        // Sort
        $sort = request('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $mains = $query->paginate(10);
        return view('main.index', compact('mains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('main.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMainRequest $request)
    {
        Main::create($request->validated());
        return redirect()->route('main.index')->with('success', 'Main content created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Main $main)
    {
        return view('main.show', compact('main'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Main $main)
    {
        return view('main.edit', compact('main'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMainRequest $request, Main $main)
    {
        $main->update($request->validated());
        return redirect()->route('main.index')->with('success', 'Main content updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Main $main)
    {
        $main->delete();
        return redirect()->route('main.index')->with('success', 'Main content deleted successfully!');
    }
}
