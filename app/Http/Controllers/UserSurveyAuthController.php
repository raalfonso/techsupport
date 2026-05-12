<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserSurvey;
use App\Http\Controllers\Controller;

class UserSurveyAuthController extends Controller
{


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('userSurvey')->attempt($credentials)) {
            $request->session()->regenerate();

            // this to check if th user first time login
            $user = Auth::guard('userSurvey')->user();
            if ($user->first_login) {
                return redirect()->route('survey.changePasswordForm');
            }
            else {
                return redirect()->route('survey.dashboard');
            }
           
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::guard('userSurvey')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/survey')->with('success', 'Logged out successfully');
    }

    

   
}