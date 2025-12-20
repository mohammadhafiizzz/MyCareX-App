<?php

namespace App\Http\Controllers\Organisation\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Show the form to request a password reset link
    public function showForgotPasswordForm() {
        return view('organisation.auth.forgotPassword');
    }

    // Show the success request for password reset
    public function showForgotPasswordSent(Request $request) {
        return view('organisation.auth.emailResetSent', ['email' => $request->query('email')]);
    }

    // Success page
    public function showSuccess() {
        return view('organisation.auth.resetSuccess');
    }

    // Handle sending of reset link email
    public function sendResetLinkEmail(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
        ]);

        // Use the organisations broker
        $status = Password::broker('organisations')->sendResetLink($credentials);

        // Redirect to the sent page with the email
        return redirect()->route('organisation.forgot.sent', ['email' => $request->email]);
    }

    // Show the reset form
    public function showResetForm(Request $request, string $token) {
        return view('organisation.auth.passwordResetForm', [
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

        $status = Password::broker('organisations')->reset(
            $credentials,
            function ($organisation, $password) {
                // Uses organisation::setPasswordAttribute mutator to hash
                $organisation->password = $password;
                // Optionally regenerate remember token
                $organisation->setRememberToken(Str::random(60));
                $organisation->save();

                event(new PasswordReset($organisation));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('organisation.password.reset.success')->with('status', __($status))
            : back()->withErrors(['email' => __($status)])->withInput();
    }
}
