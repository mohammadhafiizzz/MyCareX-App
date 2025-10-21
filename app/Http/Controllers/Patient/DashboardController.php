<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Define route for patient dashboard
    public function index() {
        return view('patient.dashboard');
    }

    // Define route for my records
    public function myRecords() {
        
        // 1. Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();

        // 2. Query the Condition model for this patient
        $conditions = Condition::where('patient_id', $patientId)
                                ->orderBy('created_at', 'desc') // Get the newest ones first
                                ->take(3)                       // Limit to 3 records
                                ->get();

        // 3. Pass the $conditions collection to the view
        return view('patient.myrecords', [
            'conditions' => $conditions
        ]);
    }

    /**
     * Get a specific condition as JSON for the edit modal.
     * NOTE: This method is likely unused here. Your web.php routes
     * to 'MedicalConditionController' for this, which is correct.
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
}