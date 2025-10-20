<?php

namespace App\Http\Controllers\Patient\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Handle Login
    public function login(Request $request) {
        $this->checkTooManyFailedAttempts($request);

        // Field validation
        $credentials = $request->validate([
            'ic_number' => 'required|string|size:14',
            'password' => 'required|string'
        ]);

        $remember = $request->boolean('remember');

        if (Auth::guard('patient')->attempt($credentials, $remember)) {
            $patient = Auth::guard('patient')->user();
            
            // Check email verification if using MustVerifyEmail
            if ($patient instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$patient->hasVerifiedEmail()) {
                Auth::guard('patient')->logout();
                RateLimiter::hit($this->throttleKey($request));
                
                return back()
                    ->withInput($request->only('ic_number'))
                    ->with('login_error', 'Please verify your email address before logging in.');
            }

            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();

            // Update last login timestamp
            $patient->last_login = now();
            $patient->save();

            return redirect()->intended(route('patient.dashboard'))
                ->with('success', 'Welcome back, ' . $patient->full_name . '!');
        }

        RateLimiter::hit($this->throttleKey($request));

        return back()
            ->withInput($request->only('ic_number'))
            ->with('login_error', 'The IC number or password is incorrect.');
    }

    // Handle Logout
    public function logout(Request $request) {
        Auth::guard('patient')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')
            ->with('success', 'You have been logged out successfully.');
    }

    // Throttle login attempts
    protected function checkTooManyFailedAttempts(Request $request) {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            
            throw ValidationException::withMessages([
                'ic_number' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }
    }

    // Generate throttle key
    protected function throttleKey(Request $request) {
        return 'login.' . $request->input('ic_number') . '|' . $request->ip();
    }
}
