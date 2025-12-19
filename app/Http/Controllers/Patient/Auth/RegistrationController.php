<?php

namespace App\Http\Controllers\Patient\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class RegistrationController extends Controller
{

    // Show the patient registration form
    public function showRegistrationForm() {
        return view('patient.auth.registration');
    }

    // Show email verification notice
    public function showEmailVerificationNotice() {
        return view('patient.auth.verifyEmail');
    }

    // Show email verified success page
    public function showEmailVerified() {
        return view('patient.auth.emailVerified');
    }

    // Handle the patient registration
    public function register(Request $request) {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:100',
            'ic_number' => 'required|string|max:20|unique:patients,ic_number',
            'email' => 'required|email|max:100|unique:patients,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Create the patient
        $patient = Patient::create($validatedData);

        // Email verification
        $patient->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')
            ->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    // Verify email address
    public function verify(Request $request) {
        $patient = Patient::find($request->route('id'));
        
        if (!hash_equals((string) $request->route('hash'), sha1($patient->getEmailForVerification()))) {
            abort(403);
        }

        if ($patient->markEmailAsVerified()) {
            event(new Verified($patient));
        }

        return redirect()->route('verification.success')->with('verified', true);
    }

    // Resend verification email
    public function resend(Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('resent', true);
    }
}