<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
class GoogleController extends Controller
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
        
        

        $user = User::where('email', '=', $googleUser->email)->first();

        if (!$user) {
            
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(Str::random(16)),
                'email_verified_at' => now(),
                'level' => '0',
                'team' => 'N/A',
                'remember_token' => Str::random(24),
                'avatar' => $googleUser->avatar,
            ]);

            // abort(403, 'User not found in the system.');
        }
        else{
            $user->update([
                'email_verified_at' => now(),
                'remember_token' => Str::random(24),
                'avatar' => $googleUser->avatar,
            ]);
        }

        Auth::login($user);

        return redirect()->route('home');
    }
}