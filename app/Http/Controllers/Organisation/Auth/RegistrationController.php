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
}
