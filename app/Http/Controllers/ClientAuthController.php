<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // exit;
      
        if ($client && $client->active) {
            // Auth::guard('client')->login($client); // Use 'client' guard here
            return redirect()->route('home.index',['id'=>$client->id]);
        }

        return back()->withErrors(['email_address' => 'Your account is not active or does not exist.']);
    }

    public function logout()
    {
        Auth::guard('client')->logout();

        return redirect()->route('client.login');
    }
}

