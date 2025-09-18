<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    // Show the admin registration form
    public function showRegistrationForm() {
        $recordExists = Admin::exists();
        return view("admin.auth.adminRegister", ['recordExists' => $recordExists]);
    }
}
