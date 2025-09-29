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
            // Clear login attempts
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();

            // Redirect to dashboard
            return redirect()->intended(route('organisation.dashboard'));
        }

        // Failed login
        RateLimiter::hit($this->throttleKey($request));
        return back()
            ->withInput($request->only('id', 'remember'))
            ->with('login_error', 'Invalid ID or Password.');
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
}
