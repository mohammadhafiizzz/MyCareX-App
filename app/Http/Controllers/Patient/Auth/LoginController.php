<?php

namespace App\Http\Controllers\Patient\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Show patient login form
    public function showLoginForm() {
        return view('auth.patientLogin');
    }

    // Handle patient login
    public function login(Request $request) {
        // Validate credentials
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        // Use patient guard for authentication
        if (auth()->guard('patient')->attempt($credentials)) {
            // Regenerate session for security
            $request->session()->regenerate();
            
            // Authentication successful
            return redirect()->intended(route('patient.dashboard'));
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    // Handle patient logout
    public function logout(Request $request) {
        auth()->guard('patient')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('index');
    }
}