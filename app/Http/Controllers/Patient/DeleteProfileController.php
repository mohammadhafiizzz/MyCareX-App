<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DeleteProfileController extends Controller
{
    /**
     * Delete patient account
     */
    public function deleteAccount(Request $request) {
        $patient = $this->getAuthenticatedPatient();

        try {
            $validated = $request->validate([
                'password' => 'required|string',
            ]);

            // Verify current password using the validated 'password'
            if (!password_verify($validated['password'], $patient->password)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'The current password is incorrect.');
            }

            // Delete the patient account
            $patient->delete();
            Auth::guard('patient')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('index')
                ->with('success', 'Your account has been deleted successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while deleting your account. Please try again later.')
                ->withInput();
        }
    }

    /**
     * Delete patient's profile picture
     */
    public function deleteProfilePicture(Request $request) {
        // Get the authenticated patient
        $patient = $this->getAuthenticatedPatient();

        try {
            // Check if there is a profile image to delete
            if ($patient->profile_image_url) {
                // Extract the filename from the URL
                $url = $patient->profile_image_url;
                $filename = basename($url);
                
                // Path to the file in the public directory
                $filePath = public_path('images/userProfile/' . $filename);
                
                // Check if file exists and delete
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
                
                // Remove the profile image URL from the database
                $patient->profile_image_url = null;
                $patient->save();
            }

            return redirect()->route('patient.profile')->with('success', 'Profile picture removed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove profile picture. Please try again.');
        }
    }

    // Private helper to get authenticated patient
    private function getAuthenticatedPatient() {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.login.form')
                ->with('error', 'Please log in to access your profile.');
        }
        return $patient;
    }
}