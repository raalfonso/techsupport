<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
       //validate
       $field = $request->validate([
        'name' => ['required', 'max:150'],
        'email' => ['required', 'max:50', 'email','unique:users'],
        'password' => ['required', 'min:3','confirmed'],
        'level' => ['required'],
        'team'  => ['required'],
        
       ]);
      
       //register
       $user = User::create($field);
       
       //Login
       Auth::login($user);
       
       //Redirect
       return redirect()->route('home');
    }

    public function login(Request $request) {
        //validate
       
       $field = $request->validate([
        'email' => ['required', 'max:50', 'email'],
        'password' => ['required'],
       ]);

       //Try to login

       if(Auth::attempt($field, $request->remember)) {
        return redirect()->intended('report');
       }
       else{
        return back()->withErrors([
            'failed' => 'The provided credentials do not match our records'
        ]);
       }
    }
    

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


} 
