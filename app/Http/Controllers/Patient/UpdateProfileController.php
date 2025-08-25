<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class UpdateProfileController extends Controller
{
    /**
     * Update patient's personal information
     */
    public function updatePersonalInfo(Request $request) {
        // Get the authenticated patient
        $patient = Auth::guard('patient')->user();

        if (!$patient) {
            return redirect()->route('index')->with('error', 'Please login to continue.');
        }

        // Validation rules
        try {
            $validatedData = $request->validate([
                'full_name' => 'required|string|max:100',
                'email' => [
                    'required',
                    'email',
                    'max:100',
                    Rule::unique('patients', 'email')->ignore(
                        $patient->getKey(),
                        $patient->getKeyName()
                    ),
                ],
                'phone_number' => 'required|string|max:15',
                'date_of_birth' => 'required|date|before:today',
                'gender' => 'required|in:male,female',
                'blood_type' => 'required|string|max:10|in:A+,A-,B+,B-,AB+,AB-,O+,O-,unknown',
                'race' => 'required|string|max:20',
                'other_race' => 'required_if:race,Other|string|max:20|nullable',
            ]);
            
            /*
            ], [
                // Custom error messages
                'full_name.required' => 'Full name is required.',
                'full_name.max' => 'Full name cannot exceed 100 characters.',
                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email address is already registered.',
                'phone_number.required' => 'Phone number is required.',
                'date_of_birth.required' => 'Date of birth is required.',
                'date_of_birth.before' => 'Date of birth must be in the past.',
                'gender.required' => 'Please select your gender.',
                'gender.in' => 'Please select a valid gender option.',
                'blood_type.required' => 'Blood type is required.',
                'blood_type.in' => 'Please select a valid blood type.',
                'race.required' => 'Race is required.',
                'other_race.required_if' => 'Please specify your race when "Other" is selected.',
            ]);
            */

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Error handling for validation failures
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('error', 'Please check the form for errors.');
        }

        try {
            // Handle "Other" race input
            if ($request->race === 'Other') {
                $validatedData['race'] = $request->other_race;
            }

            // Remove the 'other_race' field from validated data
            unset($validatedData['other_race']);

            // Calculate age from date of birth
            $dateOfBirth = new \DateTime($validatedData['date_of_birth']);
            $today = new \DateTime('today');
            $age = $dateOfBirth->diff($today)->y;
            $validatedData['age'] = $age;

            // Update the patient record
            $patient->update($validatedData);

            // Refresh the patient model to get updated data
            $patient->refresh();

            // Return success response
            return redirect()->route('patient.profile')->with('success', 'Personal information updated successfully!');

        } catch (\Exception $e) {
            // Error handling for unexpected issues
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while updating your information. Please try again.');
        }
    }

    /**
     * Update patient's physical information
     * TODO: Implement in future iterations
     */
    public function updatePhysicalInfo(Request $request)
    {
        // Will be implemented later
        return redirect()->back()->with('info', 'Physical information update feature coming soon.');
    }

    /**
     * Update patient's address information
     * TODO: Implement in future iterations
     */
    public function updateAddressInfo(Request $request)
    {
        // Will be implemented later
        return redirect()->back()->with('info', 'Address information update feature coming soon.');
    }

    /**
     * Update patient's emergency contact information
     * TODO: Implement in future iterations
     */
    public function updateEmergencyInfo(Request $request)
    {
        // Will be implemented later
        return redirect()->back()->with('info', 'Emergency contact update feature coming soon.');
    }

    /**
     * Update patient's password
     * TODO: Implement in future iterations
     */
    public function updatePassword(Request $request)
    {
        // Will be implemented later
        return redirect()->back()->with('info', 'Password update feature coming soon.');
    }

    /**
     * Update patient's profile picture
     * TODO: Implement in future iterations
     */
    public function updateProfilePicture(Request $request)
    {
        // Will be implemented later
        return redirect()->back()->with('info', 'Profile picture update feature coming soon.');
    }

    /**
     * Delete patient account
     * TODO: Implement in future iterations
     */
    public function deleteAccount(Request $request)
    {
        // Will be implemented later
        return redirect()->back()->with('info', 'Account deletion feature coming soon.');
    }

    /**
     * Helper method to calculate BMI
     * Will be used when implementing physical info update
     */
    private function calculateBMI($height, $weight)
    {
        if (!$height || !$weight || $height <= 0 || $weight <= 0) {
            return null;
        }

        $heightInMeters = $height / 100; // Convert cm to meters
        $bmi = $weight / ($heightInMeters * $heightInMeters);

        return round($bmi, 1);
    }

    /**
     * Helper method to generate full address
     * Will be used when implementing address update
     */
    private function generateFullAddress($address, $postalCode, $state)
    {
        return trim($address . ', ' . $postalCode . ' ' . $state);
    }
}