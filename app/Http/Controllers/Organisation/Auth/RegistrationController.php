<?php

namespace App\Http\Controllers\Organisation\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    // Show Organisation Registration Form
    public function showRegistrationForm() {
        return view('organisation.auth.providerRegister');
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

        
    }
}
