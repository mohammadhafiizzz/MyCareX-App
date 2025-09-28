<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Route for patient profile
    public function showProfilePage() {
        return view('patient.auth.profile');
    }
}
