<?php

namespace App\Http\Controllers\Organisation\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HealthcareProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Date;

class RegistrationController extends Controller
{
    // Show Organisation Registration Form
    public function showRegistrationForm() {
        return view('organisation.auth.registration');
    }

    // Show email verification notice
    public function showEmailVerificationNotice() {
        return view('organisation.auth.verifyEmail');
    }

    // Show email verified success page
    public function showEmailVerified() {
        return view('organisation.auth.emailVerified');
    }

    // Handle Organisation Registration
    public function register(Request $request) {
        // Check if a healthcare provider exists with this Email Address
        $existingHCPByEmail = HealthcareProvider::where('email', $request->email)->first();

        if ($existingHCPByEmail) {
            // If the provider exists and has verified their email
            if ($existingHCPByEmail->hasVerifiedEmail()) {
                return back()->withErrors([
                    'email' => 'This email address is already registered. Please use another email address.'
                ])->withInput();
            }
            // If unverified, delete the stale record
            $existingHCPByEmail->delete();
        }

        // Registration logic for organisation
        $validatedData = $request->validate([
            'organisation_name' => 'required|string|max:150',
            'email' => 'required|email|max:100|unique:healthcare_providers,email',
            'contact_person_name' => 'required|string|max:100',
            'password' => 'required|min:8|confirmed',
        ]);

        // Verification status
        $validatedData['verification_status'] = 'Pending';
        $validatedData['registration_date'] = now();

        // Create the organisation (HealthcareProvider)
        $healthcareProvider = HealthcareProvider::create($validatedData);

        // Send email verification if applicable
        if ($healthcareProvider && !$healthcareProvider->hasVerifiedEmail()) {
            $healthcareProvider->sendEmailVerificationNotification();
        }

        // Redirect with success message
        return redirect()->route('organisation.verification.notice')
            ->with('success', 'Registration successful! Please verify your email before logging in.');
    }

    // Verify email address
    public function verify(Request $request) {
        $healthcareProvider = HealthcareProvider::find($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($healthcareProvider->getEmailForVerification()))) {
            abort(403);
        }

        if ($healthcareProvider->markEmailAsVerified()) {
            event(new Verified($healthcareProvider));
        }

        return redirect()->route('organisation.verification.success')->with('verified', true);
    }

    // Resend verification email
    public function resend(Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('resent', true);
    }
}
