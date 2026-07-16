<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class PasswordResetController extends Controller
{
    public function showForgot()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $data['email'])->first();

        // Always respond the same way, whether or not the email exists, so we
        // don't reveal which addresses have accounts.
        if ($user) {
            $code = (string) random_int(100000, 999999);

            PasswordResetOtp::where('email', $user->email)->delete();

            PasswordResetOtp::create([
                'email' => $user->email,
                'code' => Hash::make($code),
                'expires_at' => now()->addMinutes(10),
            ]);

            Mail::raw(
                "Your YAXENCE LUXE password reset code is: {$code}\n\nThis code expires in 10 minutes. If you didn't request this, you can ignore this email.",
                function ($message) use ($user) {
                    $message->to($user->email)->subject('Your YAXENCE LUXE reset code');
                }
            );
        }

        return redirect()->route('password.verify', ['email' => $data['email']])
            ->with('status', 'If that email has an account, a reset code has been sent.');
    }

    public function showVerify(Request $request)
    {
        return view('auth.reset-password', ['email' => $request->query('email')]);
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $otp = PasswordResetOtp::where('email', $data['email'])
            ->where('expires_at', '>=', now())
            ->latest('id')
            ->first();

        if (! $otp || ! Hash::check($data['code'], $otp->code)) {
            return back()->withErrors(['code' => 'That code is invalid or has expired.'])->withInput();
        }

        $user = User::where('email', $data['email'])->firstOrFail();
        $user->update(['password' => $data['password']]);

        PasswordResetOtp::where('email', $data['email'])->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset. Sign in with your new password.');
    }
}
