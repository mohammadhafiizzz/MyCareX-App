<?php

namespace App\Http\Controllers\Modules\medicalCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class MedicalConditionController extends Controller
{
    // Show Medical Condition Main Page
    public function index() {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Condition model to find all records for this patient
        $conditions = Condition::where('patient_id', $patientId)->get();

        return view('patient.modules.medicalCondition.medicalCondition', [
            'conditions' => $conditions
        ]);
    }

    /**
     * Get a specific condition as JSON for the edit modal.
     */
    public function getConditionJson(Condition $condition)
    {
        // Policy/Gate check: Ensure this condition belongs to the authenticated patient
        if ($condition->patient_id !== Auth::guard('patient')->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Return the condition data
        return response()->json([
            'condition' => $condition
        ]);
    }

    /**
     * Show details of a specific medical condition
     */
    public function moreInfo(Condition $condition) {
        // Policy/Gate check: Ensure this condition belongs to the authenticated patient
        if ($condition->patient_id !== Auth::guard('patient')->id()) {
            return redirect()->route('patient.medicalCondition')->with('error', 'Unauthorized access to medical condition.');
        }

        return view('patient.modules.medicalCondition.moreInfo', [
            'condition' => $condition
        ]);
    }
}