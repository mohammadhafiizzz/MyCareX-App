<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Condition;
use App\Models\Medication;
use App\Models\Allergy;
use App\Models\Immunisation;
use App\Models\Lab;

class MyRecordsController extends Controller
{
    /**
     * Display the main "My Records" dashboard page.
     * This page shows a summary of the 5 main modules:
     * - Medical Conditions
     * - Medications
     * - Allergies
     * - Vaccinations (Immunisations)
     * - Lab Tests
     * 
     * Each module displays the 3 most recently updated records.
     */
    public function index()
    {
        // Get authenticated patient ID
        $patientId = Auth::guard('patient')->id() ?? Auth::id();

        // Fetch the 3 most recently updated records for each module
        // Sorted by updated_at DESC, limit to 3 records

        // 1. Medical Conditions
        $recentConditions = Condition::where('patient_id', $patientId)
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();

        // 2. Medications
        $recentMedications = Medication::where('patient_id', $patientId)
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();

        // 3. Allergies
        $recentAllergies = Allergy::where('patient_id', $patientId)
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();

        // 4. Vaccinations (Immunisations)
        $recentVaccinations = Immunisation::where('patient_id', $patientId)
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();

        // 5. Lab Tests
        $recentLabTests = Lab::where('patient_id', $patientId)
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();

        // Get total counts for each module (for statistics cards)
        $totalConditions = Condition::where('patient_id', $patientId)->count();
        $totalMedications = Medication::where('patient_id', $patientId)->count();
        $totalAllergies = Allergy::where('patient_id', $patientId)->count();
        $totalVaccinations = Immunisation::where('patient_id', $patientId)->count();
        $totalLabTests = Lab::where('patient_id', $patientId)->count();

        // Get specific counts for additional statistics
        $severeConditions = Condition::where('patient_id', $patientId)
            ->where('severity', 'Severe')
            ->count();
        $severeAllergies = Allergy::where('patient_id', $patientId)
            ->where('severity', 'Severe')
            ->count();

        // Pass all data to the view
        return view('patient.myrecords', [
            'recentConditions' => $recentConditions,
            'recentMedications' => $recentMedications,
            'recentAllergies' => $recentAllergies,
            'recentVaccinations' => $recentVaccinations,
            'recentLabTests' => $recentLabTests,
            'totalConditions' => $totalConditions,
            'totalMedications' => $totalMedications,
            'totalAllergies' => $totalAllergies,
            'totalVaccinations' => $totalVaccinations,
            'totalLabTests' => $totalLabTests,
            'severeConditions' => $severeConditions,
            'severeAllergies' => $severeAllergies,
        ]);
    }
}
