<?php

namespace App\Http\Controllers\Modules\Medication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Condition;
use App\Models\Medication;
use Illuminate\Support\Facades\Auth;

class MedicationController extends Controller
{
    // Show medication page
    public function index() {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        
        // Get conditions for the navigation component
        $conditions = Condition::where('patient_id', $patientId)->get();

        // Get medications for the patient for the dashboard
        $medications = Medication::where('patient_id', $patientId)
            ->orderByDesc('updated_at')
            ->orderByDesc('start_date')
            ->get();
        
        return view('patient.modules.medication.medication', [
            'conditions' => $conditions,
            'medications' => $medications,
        ]);
    }
}