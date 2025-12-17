<?php

namespace App\Http\Controllers\Doctor\Auth;

use App\Http\Controllers\Controller;
use App\Models\HealthcareProvider;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // return doctor login page
    public function index() {

        // retrieve all available healthcare providers from the database
        $healthcareProviders = HealthcareProvider::select('id', 'organisation_name')->get();

        return view('doctor.auth.login', compact('healthcareProviders'));
    }
}
