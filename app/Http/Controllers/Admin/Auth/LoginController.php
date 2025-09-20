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
        return view("admin.auth.adminLogin");
    }

    // Handle Login
    public function login(Request $request) {
        $this->checkTooManyFailedAttempts($request);

        // Field validation
        $credentials = $request->validate([
            'admin_id' => 'required|string|size:7',
            'password' => 'required|string'
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            // Check if account is verified by the Super Admin
            

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . Auth::guard('admin')->user()->name . '!');
        }

        return back()
            ->withInput($request->only('admin_id'))
            ->with('login_error', 'The admin ID or password is incorrect.');
    }

    // Handle Logout
    public function logout(Request $request) {

    }

    // Throttle login attempts
    protected function checkTooManyFailedAttempts(Request $request) {

    }

    // Generate throttle key
    protected function throttleKey(Request $request) {

    }
}
