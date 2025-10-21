<?php

namespace App\Http\Controllers\Modules\MedicalCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class AddConditionController extends Controller
{
    // Add new medical condition for a patient
    public function add(Request $request) {
        $validatedData = $request->validate([
            'condition_name' => 'required|string|max:255',
            'diagnosis_date' => 'nullable|date',
            'description' => 'nullable|string',
            'severity' => 'required|in:Mild,Moderate,Severe',
            'status' => 'required|in:Active,Resolved,Chronic',
        ]);

        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        $validatedData['patient_id'] = $patientId;

        // Create new condition record
        Condition::create($validatedData);

        // Return back with success message
        return redirect()->back()->with('message', 'Medical condition added successfully');
    }
}
