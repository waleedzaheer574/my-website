<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->isAdmin() ? 'dashboard' : 'user.dashboard');
        }

        return view('auth.login');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->isAdmin() ? 'dashboard' : 'user.dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard')->with('success', 'Account created successfully.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user) {
            return back()->withErrors([
                'email' => 'This email address is not registered.',
            ])->onlyInput('email');
        }

        if (! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'The password you entered is incorrect.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $route = Auth::user()->isAdmin() ? 'dashboard' : 'user.dashboard';

            return redirect()->intended(route($route));
        }

        return back()->withErrors([
            'email' => 'We could not sign you in. Please try again.',
        ])->onlyInput('email');
    }

    public function showForgotPasswordForm()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->isAdmin() ? 'dashboard' : 'user.dashboard');
        }

        return view('auth.forgot-password');
    }

    public function resetForgottenPassword(Request $request)
    {
        if (! $request->filled('otp_sent') && ! $request->filled('otp_verified')) {
            $data = $request->validate([
                'email' => ['required', 'email', 'exists:users,email'],
            ], [
                'email.exists' => 'This email address is not registered.',
            ]);

            $user = User::where('email', $data['email'])->firstOrFail();
            $otp = (string) random_int(100000, 999999);

            $user->forceFill([
                'password_reset_otp' => Hash::make($otp),
                'password_reset_otp_expires_at' => now()->addMinutes(10),
            ])->save();

            try {
                Mail::to($user->email)->send(new PasswordResetOtp($user, $otp));
            } catch (\Throwable $exception) {
                report($exception);

                return back()->withErrors([
                    'email' => 'OTP email could not be sent right now. Please try again.',
                ])->onlyInput('email');
            }

            return view('auth.forgot-password', [
                'otpEmail' => $data['email'],
            ])->with('status', 'OTP sent to your email.');
        }

        if ($request->filled('otp_sent') && ! $request->filled('otp_verified')) {
            $data = $request->validate([
                'email' => ['required', 'email', 'exists:users,email'],
                'otp_sent' => ['required', 'accepted'],
                'otp' => ['required', 'digits:6'],
            ], [
                'email.exists' => 'This email address is not registered.',
            ]);

            $user = User::where('email', $data['email'])->firstOrFail();

            if (
                ! $user->password_reset_otp
                || ! $user->password_reset_otp_expires_at
                || $user->password_reset_otp_expires_at->isPast()
                || ! Hash::check($data['otp'], $user->password_reset_otp)
            ) {
                return view('auth.forgot-password', [
                    'otpEmail' => $data['email'],
                ])->withErrors([
                    'otp' => 'OTP is invalid or expired.',
                ]);
            }

            return view('auth.forgot-password', [
                'verifiedEmail' => $data['email'],
            ])->with('status', 'OTP verified. Please create your new password.');
        }

        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp_verified' => ['required', 'accepted'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ], [
            'email.exists' => 'This email address is not registered.',
        ]);

        $user = User::where('email', $data['email'])->firstOrFail();

        $user->forceFill([
            'password' => Hash::make($data['password']),
            'remember_token' => Str::random(60),
            'password_reset_otp' => null,
            'password_reset_otp_expires_at' => null,
        ])->save();

        return redirect()->route('login')->with('status', 'Password reset successfully. Please login with your new password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
