<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Route for patient profile
    public function showProfilePage() {
        $patient = Auth::guard('patient')->user();
        
        // Profile completion check
        $requiredProfileFields = [
            'phone_number',
            'date_of_birth',
            'gender',
            'blood_type',
            'race',
            'height',
            'weight',
            'address',
            'postal_code',
            'state',
            'emergency_contact_number',
            'emergency_contact_name',
            'emergency_contact_ic_number',
            'emergency_contact_relationship',
        ];
        $missingProfileFields = collect($requiredProfileFields)->filter(fn ($field) => blank($patient->$field));
        $needsProfileCompletion = $missingProfileFields->isNotEmpty();
        $missingFieldsCount = $missingProfileFields->count();
        
        // Prepare profile data with safe null handling
        $profileData = [
            'patient' => $patient,
            'needsProfileCompletion' => $needsProfileCompletion,
            'missingFieldsCount' => $missingFieldsCount,
            'lastLogin' => $patient->last_login ? $patient->last_login->diffForHumans() : 'Just now',
            'age' => $patient->age ?? 'N/A',
            'dateOfBirth' => $patient->date_of_birth ? $patient->date_of_birth->format('d M Y') : 'Not specified',
            'accountCreated' => $patient->created_at ? $patient->created_at->format('d M Y, H:i') : 'Unknown',
            'fullAddress' => $patient->full_address ?? 'No address on file',
            
            // BMI calculation with safety checks
            'bmi' => $patient->bmi,
            'bmiColor' => $this->getBmiColor($patient->bmi),
            'bmiLabel' => $this->getBmiLabel($patient->bmi),
            
            // Safe field access
            'height' => $patient->height ?? '--',
            'weight' => $patient->weight ?? '--',
            'bloodType' => $patient->blood_type,
            'race' => $patient->race ?? 'Not specified',
            'address' => $patient->address ?? 'Not specified',
            'postalCode' => $patient->postal_code ?? 'Not specified',
            'state' => $patient->state ?? 'Not specified',
            'phoneNumber' => $patient->phone_number ?? 'Not specified',
            
            // Emergency contact
            'emergencyName' => $patient->emergency_contact_name ?? 'Not specified',
            'emergencyRelationship' => $patient->emergency_contact_relationship ?? 'Relationship not specified',
            'emergencyPhone' => $patient->emergency_contact_number ?? 'Not specified',
            'emergencyIc' => $patient->emergency_contact_ic_number ?? 'Not specified',
        ];
        
        return view('patient.auth.profile', $profileData);
    }
    
    /**
     * Get BMI color class based on value
     */
    private function getBmiColor($bmi)
    {
        if (!$bmi) {
            return 'text-gray-900';
        }
        
        if ($bmi < 18.5) {
            return 'text-blue-600';
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            return 'text-green-600';
        } elseif ($bmi >= 25 && $bmi < 30) {
            return 'text-yellow-600';
        } else {
            return 'text-red-600';
        }
    }
    
    /**
     * Get BMI label based on value
     */
    private function getBmiLabel($bmi)
    {
        if (!$bmi) {
            return 'BMI';
        }
        
        if ($bmi < 18.5) {
            return 'Underweight';
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            return 'Normal';
        } elseif ($bmi >= 25 && $bmi < 30) {
            return 'Overweight';
        } else {
            return 'Obese';
        }
    }
}
