<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class RegistrationController extends Controller
{
    // Show the admin registration form
    public function showRegistrationForm() {
        $recordExists = Admin::exists();
        return view("admin.auth.adminRegister", ['recordExists' => $recordExists]);
    }

    // Handle the admin registration
    public function register(Request $request) {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:100',
            'ic_number' => 'required|string|max:20|unique:admins,ic_number',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:100|unique:admins,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'nullable|in:superadmin,admin',
            'profile_image_url' => 'nullable|string',
        ]);

        // Determine role
        if (!Admin::exists()) {
            // First admin is Super Admin, Verified by default
            $validatedData['role'] = 'superadmin';
            $validatedData['email_verified_at'] = now();
            $validatedData['account_verified_at'] = now();
        } else {
            $validatedData['role'] = 'admin'; // Subsequent admins are regular Admins
        }

        // Create a new admin user
        $admin = Admin::create($validatedData);

        // Redirect with success message
        return redirect()->route('admin.login')->with('success', 'Registration successful! Please verify your email before logging in.');
    }
}
