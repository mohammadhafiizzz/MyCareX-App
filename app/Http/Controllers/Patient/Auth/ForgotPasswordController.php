<?php

namespace App\Http\Controllers\Patient\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // Show the form to request a password reset link
    public function showLinkRequestForm() {
        return view('patient.auth.passwordEmailForm');
    }

    // Success page
    public function showSuccess() {
        return view('patient.auth.passwordResetSuccess');
    }

    // Handle sending of reset link email
    public function sendResetLinkEmail(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
        ]);

        // Use the patients broker
        $status = Password::broker('patients')->sendResetLink($credentials);

        // Always return a generic response for privacy
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->with('status', __($status));
    }

    // Show the reset form
    public function showResetForm(Request $request, string $token) {
        return view('patient.auth.passwordResetForm', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    // Handle the password reset
    public function reset(Request $request) {
        $credentials = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::broker('patients')->reset(
            $credentials,
            function ($patient, $password) {
                // Uses Patient::setPasswordAttribute mutator to hash
                $patient->password = $password;
                // Optionally regenerate remember token
                $patient->setRememberToken(Str::random(60));
                $patient->save();

                event(new PasswordReset($patient));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('password.reset.success')->with('status', __($status))
            : back()->withErrors(['email' => __($status)])->withInput();
    }
}
