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
        return view('patient.dashboard');
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