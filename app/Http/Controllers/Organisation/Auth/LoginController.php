<?php

namespace App\Http\Controllers\Organisation\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\HealthcareProvider;

class LoginController extends Controller
{
    // Organisation Login Page
    public function showLoginPage() {
        return view("organisation.auth.login");
    }

    // Throttle login attempts
    protected function checkTooManyFailedAttempts(Request $request) {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            
            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }
    }

    // Generate throttle key
    protected function throttleKey(Request $request) {
        return 'login.' . $request->input('email') . '|' . $request->ip();
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

        // Check if account exists first
        $organisation = HealthcareProvider::where('email', $credentials['email'])->first();

        if (!$organisation) {
            // Account does not exist at all
            RateLimiter::hit($this->throttleKey($request));
            
            return back()
                ->withInput($request->only('email', 'remember'))
                ->with('error', 'Account does not exist. Please sign up.');
        }

        // Login attempt
        if (Auth::guard('organisation')->attempt($credentials, $remember)) {
            $organisation = Auth::guard('organisation')->user();
            
            // Check email verification
            if (!$organisation->hasVerifiedEmail()) {
                Auth::guard('organisation')->logout();
                RateLimiter::hit($this->throttleKey($request));
                
                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->with('error', 'Account does not exist. Please sign up.');
            }
            
            // Clear login attempts
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();

            // Update last login timestamp
            $organisation->last_login = now();
            $organisation->save();

            // Redirect to dashboard
            return redirect()->intended(route('organisation.dashboard'))
                ->with('success', 'Welcome back, ' . $organisation->organisation_name . '!');
        }

        // Failed login
        RateLimiter::hit($this->throttleKey($request));
        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'Invalid email or Password.');
    }

    // Organisation Logout
    public function logout(Request $request) {
        auth()->guard('organisation')->logout();
        
        $request->session()->regenerate();
        $request->session()->regenerateToken();
        
        return redirect()->route('organisation.index');
    }
}
