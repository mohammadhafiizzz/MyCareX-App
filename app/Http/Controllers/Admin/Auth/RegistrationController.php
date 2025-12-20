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
        return view("admin.auth.registration", ['recordExists' => $recordExists]);
    }

    // Handle the admin registration
    public function register(Request $request) {
        // ---------------------------------------------------------
        // STEP 1: Handle Existing Accounts
        // ---------------------------------------------------------
        
        // Check if an admin exists with this IC Number
        $existingAdminByIC = Admin::where('ic_number', $request->ic_number)->first();

        if ($existingAdminByIC) {
            // If the admin exists and has verified their email
            if ($existingAdminByIC->email_verified_at !== null) {
                return back()->withErrors([
                    'ic_number' => 'This IC number is already registered. Please login instead.'
                ])->withInput();
            }
            // If unverified, delete the stale record
            $existingAdminByIC->delete();
        }

        // Check if an admin exists with this Email Address
        $existingAdminByEmail = Admin::where('email', $request->email)->first();

        if ($existingAdminByEmail) {
            // If the admin exists and has verified their email
            if ($existingAdminByEmail->email_verified_at !== null) {
                return back()->withErrors([
                    'email' => 'This email address is already registered. Please use another email address.'
                ])->withInput();
            }
            // If unverified, delete the stale record
            $existingAdminByEmail->delete();
        }

        // ---------------------------------------------------------
        // STEP 2: Standard Validation
        // ---------------------------------------------------------
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

        // ---------------------------------------------------------
        // STEP 3: Determine Role & Create Admin
        // ---------------------------------------------------------
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
        Admin::create($validatedData);

        // Redirect with success message
        return redirect()->route('admin.login')->with('success', 'Registration successful! Please verify your email before logging in.');
    }
}
