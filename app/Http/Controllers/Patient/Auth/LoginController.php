<?php

namespace App\Http\Controllers\Patient\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
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
            'ic_number' => 'required|string|size:14', // Expect format: XXXXXX-XX-XXXX
            'password' => 'required|string'
        ]);

        // **FIX: Use IC number AS-IS (with dashes) - don't strip them**
        $icNumber = $request->ic_number;
        
        Log::info('Login attempt started', [
            'ic_number' => $icNumber,
            'ip' => $request->ip()
        ]);

        $patient = Patient::where('ic_number', $icNumber)->first();
        if (!$patient) {
            Log::warning('Patient not found', ['ic_number' => $icNumber]);
            
            RateLimiter::hit($this->throttleKey($request));
            
            throw ValidationException::withMessages([
                'ic_number' => 'The IC number or password is incorrect.',
            ]);
        }

        Log::info('Patient found', [
            'patient_id' => $patient->patient_id,
            'ic_number' => $patient->ic_number
        ]);

        $credentials = [
            'ic_number' => $icNumber, // Use the formatted IC with dashes
            'password' => $request->password
        ];
        $remember = $request->boolean('remember');

        if (Auth::guard('patient')->attempt($credentials, $remember)) {
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();
            
            Log::info('Patient logged in successfully', [
                'patient_id' => Auth::guard('patient')->user()->patient_id,
                'ic_number' => Auth::guard('patient')->user()->ic_number,
                'ip' => $request->ip()
            ]);

            return redirect()->intended(route('patient.dashboard'))
                ->with('success', 'Welcome back, ' . Auth::guard('patient')->user()->full_name . '!');
        }

        RateLimiter::hit($this->throttleKey($request));

        Log::warning('Authentication failed', [
            'ic_number' => $icNumber,
            'ip' => $request->ip()
        ]);

        throw ValidationException::withMessages([
            'ic_number' => 'The IC number or password is incorrect.',
        ]);
    }

    public function logout(Request $request) {
        $user = Auth::guard('patient')->user();
        
        if ($user) {
            Log::info('Patient logged out', [
                'patient_id' => $user->patient_id,
                'ic_number' => $user->ic_number,
                'ip' => $request->ip()
            ]);
        }
        
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