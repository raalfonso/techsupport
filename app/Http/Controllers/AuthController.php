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
        'username' => ['required', 'max:50'],
        'email' => ['required', 'max:50', 'email','unique:users'],
        'password' => ['required', 'min:3','confirmed'],
       ]);

       //register
       $user = User::create($field);
       
       //Login
       Auth::login($user);
       
       //Redirect
       return redirect()->route('home');
    }

    public function login(Request $request) {
        
    }


} 
