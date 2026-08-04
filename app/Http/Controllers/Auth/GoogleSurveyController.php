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
            $surveyEmployee = \App\Models\SurveyEmployees::where('email', '=', $googleUser->email)->first();

            if ($surveyEmployee) {
                $user = UserSurvey::create([
                    'name'          => $surveyEmployee->name ?? $googleUser->name,
                    'email'         => $googleUser->email,
                    'password'      => \Illuminate\Support\Facades\Hash::make(Str::random(16)),
                    'department_id' => $surveyEmployee->department_id,
                    'role'          => 'user',
                    'status'        => 'active',
                ]);

                $surveyEmployee->update([
                    'user_survey_id' => $user->id,
                ]);
            } else {
                abort(403, 'Access Denied - User not found in survey system.');
            }
        }

        $user->update([
            'name' => $googleUser->name,
            'email_verified_at' => now(),
            'remember_token' => Str::random(24),
        ]);

        Auth::guard('userSurvey')->login($user);

        return redirect()->route('survey.dashboard');
    }
}