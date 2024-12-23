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
    public function index()
    {
        $issues = Issues::orderBy('id','asc')->paginate(5);
        $categories = Category::all();
        $mains = Main::all();
        // $issues = Issues::orderBy('name','asc')->get();
        

        return view('issues.index',['issues' => $issues,'categories' => $categories,'mains' => $mains,]);
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
            'title' => ['required', 'max:50'],
            'category_id' => ['required'], 
            'mains_id'  => ['required'],
        ]);

        // create issues 
        Issues::create($fields);

        return redirect()->route('issues.index');
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
    public function edit(Issues $issues)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIssuesRequest $request, Issues $issues)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Issues $issues)
    {
        //
    }
}
