<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class ClientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('home.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_address' => ['required','email','exists:clients,email_address'],
        ]);

        $credentials = $request->only('email_address');
        $client = \App\Models\Clients::where('email_address', $request->email_address)->first();
        
      
        if ($client && $client->active) {
            // Auth::guard('client')->login($client); // Use 'client' guard here
            // return redirect()->route('home.index',['client'=>$client]);

            $reports = Report::where('client_id',$client->id)->get();
            $feedback = "False";
            $id="";
            foreach($reports as $report){
                if ($report->feedback == "No") {
                    $feedback = "True";
                    $id = $report->id;
                    
                }
              
            }
         
            return view('home.index',['client' => $client,'reports' => $reports,'feedback'=> $feedback,'id' => $id]);
        }

        return back()->withErrors(['email_address' => 'Your account is not active or does not exist.']);
    }

    public function logout()
    {
        Auth::guard('client')->logout();

        return redirect()->route('client.login');
    }
}

