<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Report;
use App\Models\Category;
use App\Models\Department;
use App\Models\Issues;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(){
        $reports = Report::orderBy('id','asc')->paginate(5);
        $categories = Category::orderBy('title', 'asc')->get();
        $departments = Department::orderBy('title', 'asc')->get();
        $issues = Issues::all();
        $users = User::all();

        return view('home.index',[
            'reports' => $reports,
            'categories' => $categories,
            'departments'   => $departments,
            'issues'    => $issues,
            'users' => $users,
        ]);
    }

    public function track(){

        return view('track');
    }

    public function add($id){
        $categories = Category::orderBy('title', 'asc')->get();
        $departments = Department::orderBy('title', 'asc')->get();
        $issues = Issues::where('mains_id', $id)->get();

        return view('home.form', [
            'categories' => $categories,
            'departments' => $departments,
            'issues' => $issues,
        ]);
    }

    public function trackView(Request $request){
        
        $fields = $request->validate([
            'ticket_number' => ['required'],
        ]);
    
        return redirect()->route('home.view', ['id' => $fields['ticket_number']]);
    }

    public function view($id){
      
        
        $reports = Report::where('ticket_number', $id )->get();
        
        // print_r($reports);
        return view('home.ticket', [
           'reports' => $reports,
        ]);
    
    }

    public function saveData(Request $request){

        $fields = $request->validate([
            'requestor_name' => ['required','string','max:50'],
            'department_id' => 'required',
            'issues_id' => 'required',
        ]);
  
        $reports = Report::create($fields);

        //Redirect
        return redirect()->route('home.view', ['id' => $reports->ticket_number]);
       

    }
}
