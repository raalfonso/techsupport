<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use App\Models\Category;
use App\Models\Main;
use Illuminate\Http\Request;


class IssuesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Issues::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('resolution_timeline', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  })
                  ->orWhereHas('mains', function ($q) use ($search) {
                      $q->where('title', 'like', "%{$search}%");
                  });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by main
        if ($request->has('main') && $request->main) {
            $query->where('mains_id', $request->main);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
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

        $issues = $query->paginate(10);
        $categories = Category::all();
        $mains = Main::all();

        return view('issues.index', [
            'issues' => $issues,
            'categories' => $categories,
            'mains' => $mains,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'category_id' => ['required'], 
            'mains_id'  => ['required'],
            'resolution_timeline'  => ['required'],
        ]);

        // create issues 
        Issues::create($fields);

        return redirect()->route('issues.index')->with('success', 'Issue created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Issues $issues)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($issue)
    {
        $categories = Category::all();
        $issues = Issues::find($issue);
        $mains = Main::all();
        return view('issues.edit', compact('issues', 'categories', 'mains'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $issues)
    {
        $fields = $request->validate([
            'title' => ['required', 'max:255'],
            'category_id' => ['required'], 
            'mains_id'  => ['required'],
            'resolution_timeline'  => ['required'],
        ]);
        // print_r($issues);
        $issues_update = Issues::find($issues);
        $issues_update->update($fields);

        return redirect()->route('issues.index')->with('success', 'Issue updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Issues $issues)
    {
        $issues->delete();
        return redirect()->route('issues.index')->with('success', 'Issue deleted successfully!');
    }
}
