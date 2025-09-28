<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class UpdateProfileController extends Controller
{
    /**
     * Update patient's personal information
     */
    public function updatePersonalInfo(Request $request) {
        // Get the authenticated patient
        $patient = $this->getAuthenticatedPatient();

        // Validation rules
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
            'gender' => 'required|in:Male,Female',
            'blood_type' => 'required|string|max:10|in:A+,A-,B+,B-,AB+,AB-,O+,O-,unknown',
            'race' => 'required|string|max:20',
            'other_race' => 'required_if:race,Other|string|max:20|nullable',
        ]);

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

        // Commit and redirect with unified helper
        return $this->updateAndRedirect($patient, $validatedData, 'Personal information updated successfully!');
    }

    /**
     * Update patient's physical information
     */
    public function updatePhysicalInfo(Request $request) {
        // Get the authenticated patient
        $patient = $this->getAuthenticatedPatient();

        // Validation rules
        $validatedData = $request->validate([
            'height' => 'required|numeric|min:30|max:300',
            'weight' => 'required|numeric|min:1|max:500',
            'bmi' => 'nullable|numeric|min:10|max:100',
        ]);

        // Calculate BMI if not provided
        if (empty($validatedData['bmi'])) {
            $validatedData['bmi'] = $patient->getBmiAttribute();
        }

        // Commit and redirect with unified helper
        return $this->updateAndRedirect($patient, $validatedData, 'Physical information updated successfully!');
    }

    /**
     * Update patient's address information
     */
    public function updateAddressInfo(Request $request) {
        // Get the authenticated patient
        $patient = $this->getAuthenticatedPatient();

        // Validation rules
        $validatedData = $request->validate([
            'address' => 'required|string',                   // longText
            'postal_code' => 'required|string|size:5',
            'state' => 'required|in:Johor,Kedah,Kelantan,Malacca,Negeri Sembilan,Pahang,Penang,Perak,Perlis,Sabah,Sarawak,Selangor,Terengganu,Kuala Lumpur,Labuan,Putrajaya',
        ]);

        // Generate full address
        $fullAddress = $patient->getFullAddressAttribute();
        $validatedData['full_address'] = $fullAddress;

        // Commit and redirect with unified helper
        return $this->updateAndRedirect($patient, $validatedData, 'Address information updated successfully!');
    }

    /**
     * Update patient's emergency contact information
     */
    public function updateEmergencyInfo(Request $request) {
        // Get the authenticated patient
        $patient = $this->getAuthenticatedPatient();

        // Validation rules
        $validatedData = $request->validate([
            'emergency_contact_number' => 'required|string|max:15',
            'emergency_contact_name' => 'required|string|max:100',
            'emergency_contact_ic_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('patients', 'emergency_contact_ic_number')->ignore(
                    $patient->getKey(),
                    $patient->getKeyName()
                ),
            ],
            'emergency_contact_relationship' => 'required|string|max:30',
            'other_relationship' => 'required_if:emergency_contact_relationship,Other|string|max:30|nullable',
        ]);

        // Handle "Other" relationship input
        if ($request->emergency_contact_relationship === 'Other') {
            $validatedData['emergency_contact_relationship'] = $request->other_relationship;
        }

        // Remove the 'other_relationship' field from validated data
        unset($validatedData['other_relationship']);

        // Commit and redirect with unified helper
        return $this->updateAndRedirect($patient, $validatedData, 'Emergency contact information updated successfully!');
    }

    /**
     * Update patient's password
     */
    public function updatePassword(Request $request) {
        // Get the authenticated patient
        $patient = $this->getAuthenticatedPatient();

        // Validation rules
        try {
            $validatedData = $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|confirmed|different:current_password',
            ]);

            // Verify current password
            if (!password_verify($validatedData['current_password'], $patient->password)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'The current password is incorrect.');
            }

            // Update to new password
            $patient->password = ($validatedData['new_password']);
            $patient->save();
            $patient->refresh();

            // Return success response
            return redirect()->route('patient.auth.profile')->with('success', 'Password updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Error handling for validation failures
            return redirect()->back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('error', 'Please check the form for errors.');
        } catch (\Exception $e) {
            // Error handling for unexpected issues
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while updating your password. Please try again.');
        }
    }

    /**
     * Update patient's profile picture
     */
    public function updateProfilePicture(Request $request) {
        // Get the authenticated patient
        $patient = $this->getAuthenticatedPatient();

        // Validate the uploaded file
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5120',
        ]);

        try {
            $file = $request->file('profile_image');

            // Target directory in public path
            $destinationPath = public_path('images/userProfile');

            // Ensure directory exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Build filename: {PATIENT_ID}_Profile_Picture.{ext}
            $patientId = $patient->patient_id; // e.g., "P0001"
            $baseName = $patientId . '_Profile_Picture';
            $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
            $filename = $baseName . '.' . $extension;

            // Move file into public/images/userProfile
            $file->move($destinationPath, $filename);

            // Build the public URL to store in DB
            $publicUrl = asset('images/userProfile/' . $filename);

            // Update only the URL in the database
            $patient->profile_image_url = $publicUrl;
            $patient->save();

            return redirect()
                ->route('patient.auth.profile')
                ->with('success', 'Profile picture updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to upload profile picture. Please try again.');
        }
    }

    // Get authenticated patient Private Method
    private function getAuthenticatedPatient() {
        // Get the authenticated patient
        $patient = Auth::guard('patient')->user();
        
        // Redirect if not authenticated
        if (!$patient) {
            return redirect()->route('index')->with('error', 'Please login to continue.');
        }

        // Return the authenticated patient
        return $patient;
    }

    // Update, Refresh, and Redirect Helper
    private function updateAndRedirect($patient, array $data, string $successMessage) {
        try {
            $patient->update($data);
            $patient->refresh();
            return redirect()->route('patient.auth.profile')->with('success', $successMessage);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'An error occurred while updating your information. Please try again.');
        }
    }
}