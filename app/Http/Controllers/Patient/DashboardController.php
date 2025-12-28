<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surgery;
use App\Models\Hospitalisation;

class DashboardController extends Controller
{
    // Define route for patient pages

    // 1. Dashboard
    public function index() {
        $patient = Auth::guard('patient')->user();
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
        
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
        
        // Get patient data counts
        $activeMedications = $patient->medications()->where('status', 'active')->count();
        $activeConditions = $patient->conditions()->where('status', 'active')->count();
        $labRecordsCount = $patient->labs()->count();
        $allergiesCount = $patient->allergies()->count();
        $severeAllergies = $patient->allergies()->where('severity', 'severe')->get();
        $pendingPermissions = \App\Models\Permission::where('patient_id', $patient->id)
            ->where('status', 'Pending')
            ->count();
        
        // Recent data
        $todayMedications = $patient->medications()->where('status', 'active')->latest()->take(4)->get();
        $recentConditions = $patient->conditions()->latest()->take(3)->get();
        $recentLabs = $patient->labs()->latest()->take(3)->get();
        $immunisations = $patient->immunisations()->latest()->take(2)->get();
        
        // Permissions data
        $recentPermissions = \App\Models\Permission::with('doctor')
            ->where('patient_id', $patient->id)
            ->latest()
            ->take(3)
            ->get();
        $activeProviders = \App\Models\Permission::where('patient_id', $patient->id)
            ->where('status', 'Active')
            ->count();
        
        // Health tips
        $tips = [
            ['icon' => 'fa-pills', 'text' => 'Take your medications at the same time each day to help build a routine and improve adherence.'],
            ['icon' => 'fa-glass-water', 'text' => 'Stay hydrated! Aim for 8 glasses of water daily to support your overall health and medication effectiveness.'],
            ['icon' => 'fa-heart-pulse', 'text' => 'Regular check-ups are essential. Schedule your next appointment to keep your health conditions monitored.'],
            ['icon' => 'fa-utensils', 'text' => 'A balanced diet rich in fruits, vegetables, and whole grains can help manage chronic conditions effectively.'],
            ['icon' => 'fa-person-walking', 'text' => 'Even 30 minutes of light exercise daily can significantly improve your health outcomes and energy levels.'],
            ['icon' => 'fa-bed', 'text' => 'Quality sleep is crucial for healing. Aim for 7-9 hours of consistent sleep each night.'],
            ['icon' => 'fa-shield-virus', 'text' => 'Keep your immunizations up to date to protect yourself from preventable diseases.'],
            ['icon' => 'fa-notes-medical', 'text' => 'Keep track of any new symptoms and discuss them with your healthcare provider during your next visit.'],
        ];
        $todayTip = $tips[now()->dayOfYear % count($tips)];
        
        return view('patient.dashboard', compact(
            'patient',
            'hour',
            'greeting',
            'needsProfileCompletion',
            'missingFieldsCount',
            'activeMedications',
            'activeConditions',
            'labRecordsCount',
            'allergiesCount',
            'severeAllergies',
            'pendingPermissions',
            'todayMedications',
            'recentConditions',
            'recentLabs',
            'immunisations',
            'recentPermissions',
            'activeProviders',
            'todayTip'
        ));
    }

    // 2. Medical History
    public function medicalHistory() {

        // Get authenticated patient ID
        $patientId = Auth::guard('patient')->id() ?? Auth::id();

        // 1. Recent Surgeries
        $recentSurgeries = Surgery::where('patient_id', $patientId)
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();

        // 2. Recent Hospitalisations
        $recentHospitalisations = Hospitalisation::where('patient_id', $patientId)
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();

        return view('patient.medicalHistory', [
            'recentSurgeries' => $recentSurgeries,
            'recentHospitalisations' => $recentHospitalisations,
        ]);
    }
}