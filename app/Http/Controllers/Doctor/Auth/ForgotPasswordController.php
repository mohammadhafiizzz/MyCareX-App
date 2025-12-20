<?php

namespace App\Http\Controllers\Doctor\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // Show the form to request a password reset link
    public function showForgotPasswordForm() {
        return view('doctor.auth.forgotPassword');
    }

    // Show the success request for password reset
    public function showForgotPasswordSent(Request $request) {
        return view('doctor.auth.emailResetSent', ['email' => $request->query('email')]);
    }

    // Success page
    public function showSuccess() {
        return view('doctor.auth.resetSuccess');
    }

    // Handle sending of reset link email
    public function sendResetLinkEmail(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
        ]);

        // Use the doctors broker
        $status = Password::broker('doctors')->sendResetLink($credentials);

        // Redirect to the sent page with the email
        return redirect()->route('doctor.forgot.sent', ['email' => $request->email]);
    }

    // Show the reset form
    public function showResetForm(Request $request, string $token) {
        return view('doctor.auth.passwordResetForm', [
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

        $status = Password::broker('doctors')->reset(
            $credentials,
            function ($doctor, $password) {
                // Uses Doctor::setPasswordAttribute mutator to hash
                $doctor->password = $password;
                // Optionally regenerate remember token
                $doctor->setRememberToken(Str::random(60));
                $doctor->save();

                event(new PasswordReset($doctor));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('doctor.password.reset.success')->with('status', __($status))
            : back()->withErrors(['email' => __($status)])->withInput();
    }
}
