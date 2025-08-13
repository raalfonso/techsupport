<?php

namespace App\Http\Controllers;

use App\Models\Resolve;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Category;
use App\Models\Department;
use App\Models\Issues;
use App\Models\UserSurvey;
use App\Models\Clients;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index()
    {
        
        return view('survey.dashboard');
    }

    public function loginSurvey(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->route('dashboard')->with('success', 'Login successful');
        }

        return redirect()->back()->withErrors(['failed' => 'Invalid credentials']);
    }
    
    public function register(Request $request) {
        // regisration form 
        $departments = Department::all();
        return view('survey.register', compact('departments'));
    }

    public function registerStore(Request $request)
    {
        //validate
      $fields = $request->validate([
            'name' => ['required', 'max:150'],
            'email' => ['required', 'max:50', 'email', 'unique:user_survey,email'],
            'password' => ['required', 'min:3', 'confirmed'],
            'role' => ['required'],
            'department_id' => ['required'],
        ]);
    
        $fields['password'] = Hash::make($fields['password']); // ✅ hash the password

        UserSurvey::create($fields);

    // Optionally log the user in
        Auth::guard('userSurvey')->login(UserSurvey::where('email', $fields['email'])->first());

        return redirect()->route('survey.dashboard')->with('success', 'Registration successful. Welcome to the survey hub!');

    }

    /**
     * Logout the user from the survey.
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    public function logoutSurvey()
    {
        auth()->logout();
        return redirect()->route('home')->with('success', 'Logged out successfully');
    }
}
