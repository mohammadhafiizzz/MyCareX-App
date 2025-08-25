<?php

namespace App\Http\Controllers\Patient\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {
        if (!$request->session()->isStarted()) {
            $request->session()->start();
        }

        $this->checkTooManyFailedAttempts($request);

        // Validate credentials - expect formatted IC with dashes
        $request->validate([
            'ic_number' => 'required|string|size:14',
            'password' => 'required|string'
        ]);

        // **FIX: Use IC number AS-IS (with dashes) - don't strip them**
        $icNumber = $request->ic_number;

        $patient = Patient::where('ic_number', $icNumber)->first();
        if (!$patient) {            
            RateLimiter::hit($this->throttleKey($request));
            
            throw ValidationException::withMessages([
                'ic_number' => 'The IC number or password is incorrect.',
            ]);
        }

        $credentials = [
            'ic_number' => $icNumber,
            'password' => $request->password
        ];
        $remember = $request->boolean('remember');

        if (Auth::guard('patient')->attempt($credentials, $remember)) {
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();

            return redirect()->intended(route('patient.dashboard'))
                ->with('success', 'Welcome back, ' . Auth::guard('patient')->user()->full_name . '!');
        }

        RateLimiter::hit($this->throttleKey($request));

        throw ValidationException::withMessages([
            'ic_number' => 'The IC number or password is incorrect.',
        ]);
    }

    public function logout(Request $request) {
        Auth::guard('patient')->user();
        
        Auth::guard('patient')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')
            ->with('success', 'You have been logged out successfully.');
    }

    protected function checkTooManyFailedAttempts(Request $request) {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));
            
            throw ValidationException::withMessages([
                'ic_number' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }
    }

    protected function throttleKey(Request $request) {
        return $request->input('ic_number') . '|' . $request->ip(); // Keep dashes in throttle key too
    }
}