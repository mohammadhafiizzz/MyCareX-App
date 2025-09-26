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
        return view('organisation.auth.providerRegister');
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
        // Registration logic for organisation
        $validatedData = $request->validate([
            'organisation_name' => 'required|string|max:150',
            'organisation_type' => 'required|string|max:100',
            'registration_number' => 'nullable|string|max:100|unique:healthcare_providers,registration_number',
            'license_number' => 'nullable|string|max:100|unique:healthcare_providers,license_number',
            'license_expiry_date' => 'nullable|date',
            'establishment_date' => 'required|date',
            'email' => 'required|email|max:100|unique:healthcare_providers,email',
            'phone_number' => 'required|string|max:15',
            'emergency_contact' => 'required|string|max:50',
            'website_url' => 'nullable|url|max:100',
            'contact_person_name' => 'required|string|max:100',
            'contact_person_phone_number' => 'required|string|max:15',
            'contact_person_designation' => 'required|string|max:100',
            'contact_person_ic_number' => 'required|string|max:20|unique:healthcare_providers,contact_person_ic_number',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|size:5',
            'state' => 'required|in:Johor,Kedah,Kelantan,Malacca,Negeri Sembilan,Pahang,Penang,Perak,Perlis,Sabah,Sarawak,Selangor,Terengganu,Kuala Lumpur,Labuan,Putrajaya',
            'business_license_document' => 'nullable|string',
            'medical_license_document' => 'nullable|string',
            'password' => 'required|min:8|confirmed',
        ]);

        // Register date
        $validatedData['registration_date'] = Date::now()->format('Y-m-d');

        // Verification status
        $validatedData['verification_status'] = 'Pending';

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
