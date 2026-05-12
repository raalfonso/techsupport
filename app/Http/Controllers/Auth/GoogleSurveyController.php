<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserSurvey;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleSurveyController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['hd' => 'bcda.gov.ph'])
            ->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Enforce BCDA domain
        if (!str_ends_with($googleUser->email, '@bcda.gov.ph')) {
            abort(403, 'Only bcda.gov.ph Google accounts are allowed.');
        }

        $user = UserSurvey::where('email', '=', $googleUser->email)->first();

        if (!$user) {
            abort(403, 'User not found in the survey system.');
        }

        $user->update([
            'email_verified_at' => now(),
            'remember_token' => Str::random(24),
        ]);

        Auth::guard('userSurvey')->login($user);

        return redirect()->route('survey.dashboard');
    }
}