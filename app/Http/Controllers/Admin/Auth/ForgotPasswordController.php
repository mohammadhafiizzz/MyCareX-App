<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // Show the form to request a password reset link
    public function showForgotPasswordForm() {
        return view('admin.auth.forgotPassword');
    }

    // Show the success request for password reset
    public function showForgotPasswordSent(Request $request) {
        return view('admin.auth.emailResetSent', ['email' => $request->query('email')]);
    }

    // Success page
    public function showSuccess() {
        return view('admin.auth.resetSuccess');
    }

    // Handle sending of reset link email
    public function sendResetLinkEmail(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
        ]);

        // Use the admins broker
        $status = Password::broker('admins')->sendResetLink($credentials);

        // Redirect to the sent page with the email
        return redirect()->route('admin.forgot.sent', ['email' => $request->email]);
    }

    // Show the reset form
    public function showResetForm(Request $request, string $token) {
        return view('admin.auth.passwordResetForm', [
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

        $status = Password::broker('admins')->reset(
            $credentials,
            function ($admin, $password) {
                // Uses Admin::setPasswordAttribute mutator to hash
                $admin->password = $password;
                // Optionally regenerate remember token
                $admin->setRememberToken(Str::random(60));
                $admin->save();

                event(new PasswordReset($admin));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('admin.password.reset.success')->with('status', __($status))
            : back()->withErrors(['email' => __($status)])->withInput();
    }
}
