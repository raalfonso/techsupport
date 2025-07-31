<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Report;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use Illuminate\Http\Request;
class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'report_id' => 'required',
            'answer1' => 'required',
            'answer2' => 'required',
            'answer3' => 'required',
            'reason'   => 'max:255',
            'suggestion'  => 'max:255',
        ]);
        // echo $request->
       

        $feedback = Feedback::create($fields);
 
        
        if ($feedback) {
            Report::where('ticket_number', $feedback->report->ticket_number)->update(['feedback' => 'Yes']);
           
        } 

        $reports = Report::where('client_id',$feedback->report->client->id)->get();
        $feedbacks = "False";
        $id = '';
            
       
        $client = \App\Models\Clients::where('id', $feedback->report->client->id)->first();
        foreach($reports as $report){
            if ($report->feedback == "No") {
                $feedbacks = "True";
                $id = $report->id;
            }
          
        }
        return view('home.index',['client' => $client,'reports' => $reports,'feedback' => $feedbacks,'id'=>$id,]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
