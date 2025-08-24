<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Report;
use App\Models\Category;
use App\Models\Department;
use App\Models\Issues;
use App\Models\User;
use App\Models\Clients;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(){
        $reports = Report::orderBy('id','asc')
        ->groupBy('ticket_number')
        ->paginate(5);
        $categories = Category::orderBy('title', 'asc')->get();
        $departments = Department::orderBy('title', 'asc')->get();
        $issues = Issues::all();
        $users = User::all();

        $feedback = "False";
     
        foreach($reports as $report){
            if ($report->feedback == "No") {
                $feedback == "True";
                $id = $report->id;
            }
        }

        return view('home.index',[
            'reports' => $reports,
            'categories' => $categories,
            'departments'   => $departments,
            'issues'    => $issues,
            'users' => $users,
            'feedback' => $feedback,
            'id'    => $id,
        ]);
    }

    public function login(){
        return view('home.login',);
    }

    public function track(){

        return view('track');
    }

    public function employeeReport()
    {
        $email = session('email');

        if (!$email) {
            return redirect()->route('home.index')->with('error', 'Session expired or missing.');
        }

        $client = Clients::where('email_address', $email)->first();
        $reports = Report::where('client_id', $client->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('home.tracking', [
            'reports' => $reports,
            'client' => $client
        ]);
    }
    // this is for checking the email is registered or not
    public function checkEmail(Request $request){

      
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'main' => ['required'],
        ]); 
       


        $client = Clients::where('email_address', $fields['email'])->first();
        if ($client) {
            if ($fields['main'] == 0) {
               
                session(['email' => $fields['email']]);
                return redirect()->route('home.employeeReport');
               
            }
            else {
                // Redirect to the add form with client_id and main
                $id = $fields['main'];
                return redirect()->route('home.add', [
                    'id' => $id,
                    'client_id' => $client->id
                ]);
            }
            
            
        } 
    }
   
    public function add($id,$client_id){
        $categories = Category::orderBy('title', 'asc')->get();
        $departments = Department::orderBy('title', 'asc')->get();
        $issues = Issues::where('mains_id', $id)->get();
        $client = Clients::where('id',$client_id)->first();
        $user_department = Report::select('department_id')->where('client_id', $client_id)->orderBy('id','desc')->first();
        return view('home.form', [
            'categories' => $categories,
            'departments' => $departments,
            'issues' => $issues,
            'client' => $client,
            'user_department' => $user_department,
        ]);
    }

    public function trackView(Request $request){
        
        $fields = $request->validate([
            'ticket_number' => ['required'],
        ]);
    
        return redirect()->route('home.view', ['id' => $fields['ticket_number']]);
    }


    public function view($id){
      
        $client = Clients::where('id', $id)->first();
        $reports = Report::where('client_id', $client->id)
        ->orderBy('id', 'desc')
        ->get();
      
        return view('home.tracking', [
            'reports' => $reports,
            'client' => $client
        ])->with('success', 'Report created successfully!');
        
    }

    public function viewStatus($id){
      
        
        $reports = Report::where('ticket_number', $id )->get();
        
        // print_r($reports);
        return view('home.status', [
           'reports' => $reports,
        ]);
    
    }

    public function feedback($id){
      
        
      return  $reports = Report::select('feedback')->where('ticket_number', $id )->get();
        
      
    
    }

    public function saveData(Request $request){
        
        $fields = $request->validate([
            'client_id' => 'required',
            'department_id' => 'required',
            'issues_id' => 'required',
            'location'  => 'required',
        ]);
        
        $fields['request_datetime'] = now();
  
        $reports = Report::create($fields);
        
        //Redirect
        return redirect()->route('home.view', ['id' => $fields['client_id']]);
       
    }


    public function cancel($id)
    {
    
        
        // // Handle the cancellation logic here, e.g., update database, etc.
        // // Example:
        $report = Report::findOrFail($id);

       
        $report->status = 'Canceled';

        $report->save();
    
        return response()->json(['message' => 'Cancellation successful']);
    }
    
}
