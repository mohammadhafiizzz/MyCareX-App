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
        return view('patient.auth.patientRegister');
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
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:100|unique:patients,email',
            'password' => 'required|min:8|confirmed',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'blood_type' => 'required|string|max:10',
            'race' => 'required|string|max:20',
            'height' => 'nullable|numeric|between:1,999.99',
            'weight' => 'nullable|numeric|between:1,999.99',
            'address' => 'required|string',
            'postal_code' => 'required|string|size:5',
            'state' => 'required|in:Johor,Kedah,Kelantan,Malacca,Negeri Sembilan,Pahang,Penang,Perak,Perlis,Sabah,Sarawak,Selangor,Terengganu,Kuala Lumpur,Labuan,Putrajaya',
            'emergency_contact_number' => 'required|string|max:15',
            'emergency_contact_name' => 'required|string|max:100',
            'emergency_contact_ic_number' => 'required|string|max:20',
            'emergency_contact_relationship' => 'required|string|max:30',
            'profile_image_url' => 'nullable|string',

            // "Other" fields
            'other_race' => 'required_if:race,Other|string|max:20|nullable',
            'other_relationship' => 'required_if:emergency_contact_relationship,Other|string|max:30|nullable'
        ]);

        // Handle other race input
        if ($request->race === 'Other') {
            $validatedData['race'] = $request->other_race;
        }

        // Handle other relationship input
        if ($request->emergency_contact_relationship === 'Other') {
            $validatedData['emergency_contact_relationship'] = $request->other_relationship;
        }

        // Remove the 'other_race' and 'other_relationship' fields
        unset($validatedData['other_race']);
        unset($validatedData['other_relationship']);

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