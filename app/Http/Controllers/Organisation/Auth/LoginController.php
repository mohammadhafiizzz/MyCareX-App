<?php

namespace App\Http\Controllers\Organisation\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Organisation Login Page
    public function showLoginPage() {
        return view("organisation.auth.login");
    }
}
