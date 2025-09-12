<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    // Show the admin registration form
    public function showRegistrationForm() {
        return view("admin.auth.adminRegister");
    }
}
