<?php

namespace App\Http\Controllers\Patient\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegistrationController extends Controller {

    // Show the patient registration form
    public function showRegistrationForm() {
        return view('auth.patientRegister');
    }

    // Handle the patient registration
    public function register(Request $request) {
        // Validate and create the patient
    }
}