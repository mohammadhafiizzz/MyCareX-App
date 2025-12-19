<?php

namespace App\Http\Controllers\Doctor\Auth;

use App\Http\Controllers\Controller;
use App\Models\HealthcareProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // return doctor login page
    public function index() {

        // retrieve all available healthcare providers from the database
        $healthcareProviders = HealthcareProvider::select('id', 'organisation_name')->get();

        return view('doctor.auth.login', compact('healthcareProviders'));
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

    // doctor login
    public function login(Request $request) {
        $this->checkTooManyFailedAttempts($request);

        // Validate credentials
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Remember me
        $remember = $request->boolean('remember');

        // Attempt login
        if (auth()->guard('doctor')->attempt($credentials, $remember)) {
            $doctor = auth()->guard('doctor')->user();

            // Clear login attempts
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();

            // Update last login timestamp
            $doctor->last_login = now();
            $doctor->save();

            return redirect()->route('doctor.dashboard');
        }

        // Failed login
        RateLimiter::hit($this->throttleKey($request));
        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('login_error', 'Invalid email or Password.');
    }

    public function logout(Request $request) {
        auth()->guard('doctor')->logout();

        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()->route('organisation.index');
    }
}
