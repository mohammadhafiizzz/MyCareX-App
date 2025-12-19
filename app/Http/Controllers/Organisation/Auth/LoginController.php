<?php

namespace App\Http\Controllers\Organisation\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // Organisation Login Page
    public function showLoginPage() {
        return view("organisation.auth.login");
    }

    // Organisation Login Action

    public function login(Request $request) {
        $this->checkTooManyFailedAttempts($request);

        // Field validation
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        // Remember me
        $remember = $request->boolean('remember');

        // Login attempt
        if (auth()->guard('organisation')->attempt($credentials, $remember)) {
            $organisation = auth()->guard('organisation')->user();
            
            // Check email verification if using MustVerifyEmail
            if ($organisation instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$organisation->hasVerifiedEmail()) {
                auth()->guard('organisation')->logout();
                RateLimiter::hit($this->throttleKey($request));
                
                return redirect()->route('organisation.verification.notice')
                    ->with('login_error', 'Please verify your email address before logging in.');
            }
            
            // Clear login attempts
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();

            // Update last login timestamp
            $organisation->last_login = now();
            $organisation->save();

            // Redirect to dashboard
            return redirect()->intended(route('organisation.dashboard'));
        }

        // Failed login
        RateLimiter::hit($this->throttleKey($request));
        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('login_error', 'Invalid email or Password.');
    }
    
    // Throttle login attempts
    protected function checkTooManyFailedAttempts(Request $request) {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            
            throw ValidationException::withMessages([
                'id' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }
    }

    // Generate throttle key
    protected function throttleKey(Request $request) {
        return 'login.' . $request->input('id') . '|' . $request->ip();
    }

    // Organisation Logout
    public function logout(Request $request) {
        auth()->guard('organisation')->logout();
        
        $request->session()->regenerate();
        $request->session()->regenerateToken();
        
        return redirect()->route('organisation.index');
    }
}
