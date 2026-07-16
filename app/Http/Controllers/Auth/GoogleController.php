<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        if (! config('services.google.client_id')) {
            return redirect()->route('login')
                ->with('status', 'Google Sign-In isn\'t set up yet. Use email and password for now.');
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        if (! config('services.google.client_id')) {
            return redirect()->route('login');
        }

        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if (! $user) {
            $name = $googleUser->getName() ?: $googleUser->getNickname() ?: 'Customer';
            [$first, $last] = array_pad(explode(' ', $name, 2), 2, '');

            $user = User::create([
                'first_name' => $first,
                'last_name' => $last,
                'name' => $name,
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Str::random(32),
            ]);
        } elseif (! $user->google_id) {
            $user->update(['google_id' => $googleUser->getId()]);
        }

        Auth::login($user, true);

        return redirect()->route('home')->with('status', 'Welcome, '.$user->first_name.'.');
    }
}
