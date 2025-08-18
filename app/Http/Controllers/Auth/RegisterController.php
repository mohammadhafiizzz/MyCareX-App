<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller {
    public function showRegistrationForm() {
        return view('auth.patientRegister');
    }

    public function register(Request $request) {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'ic_number' => 'required|string|max:14',
            'gender' => 'required|string',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'full_name' => $validatedData['full_name'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'ic_number' => $validatedData['ic_number'],
            'gender' => $validatedData['gender'],
            'phone_number' => $validatedData['phone_number'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Log the user in
        auth()->login($user);

        return redirect()->route('dashboard');
    }
}

?>