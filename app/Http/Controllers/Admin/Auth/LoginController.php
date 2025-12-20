<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    // Login Form
    public function showLoginForm() {
        return view("admin.auth.login");
    }

    // Handle Login
    public function login(Request $request) {
        $this->checkTooManyFailedAttempts($request);

        // Field validation
        $credentials = $request->validate([
            'admin_id' => 'required|string|size:7',
            'password' => 'required|string'
        ]);

        // Remember me
        $remember = $request->boolean('remember');

        /*
        // Check email verification
        if ($admin instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$admin->hasVerifiedEmail()) {
            Auth::guard('admin')->logout();
            RateLimiter::hit($this->throttleKey($request));
            
            return back()
                ->withInput($request->only('admin_id'))
                ->with('login_error', 'Please verify your email address first.');
        }
        */

        // Login attempt
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $admin = Auth::guard('admin')->user();

            // Check if account is verified by the Super Admin
            if (is_null($admin->account_verified_at)) {
                Auth::guard('admin')->logout();
                return back()
                    ->withInput($request->only('admin_id'))
                    ->with('login_error', 'Your account is not verified by the Super Admin.');
            }

            // Clear login attempts
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();

            // Redirect to dashboard
            return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Welcome back, ' . $admin->full_name . '!');
        }

        // Hit rate limiter on failed attempt
        RateLimiter::hit($this->throttleKey($request));

        return back()
            ->withInput($request->only('admin_id'))
            ->with('login_error', 'The admin ID or password is incorrect.');
    }

    // Handle Logout
    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        // Regenerate session ID to prevent session fixation, but preserve session data for other guards
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }

    // Throttle login attempts
    protected function checkTooManyFailedAttempts(Request $request) {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            
            throw ValidationException::withMessages([
                'admin_id' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }
    }

    // Generate throttle key
    protected function throttleKey(Request $request) {
        return 'login.' . $request->input('admin_id') . '|' . $request->ip();
    }
}
