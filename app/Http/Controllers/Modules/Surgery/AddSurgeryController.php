<?php

namespace App\Http\Controllers\Modules\Surgery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surgery;
use Illuminate\Support\Facades\Auth;

class AddSurgeryController extends Controller
{
    /**
     * Add new surgery record for a patient
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) {
        $validatedData = $request->validate([
            'procedure_name' => 'required|string|max:255',
            'procedure_date' => 'required|date|before_or_equal:today',
            'surgeon_name' => 'nullable|string|max:255',
            'hospital_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ], [
            'procedure_name.required' => 'Please enter the procedure name.',
            'procedure_date.required' => 'Please select the procedure date.',
            'procedure_date.before_or_equal' => 'Procedure date cannot be in the future.',
        ]);

        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Add patient_id to validated data
        $validatedData['patient_id'] = $patientId;
        
        // doctor_id is null for patient-created records
        $validatedData['doctor_id'] = null;
        
        // verification_status is false by default
        $validatedData['verification_status'] = false;

        // Create new surgery record
        $surgery = Surgery::create($validatedData);

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Surgery record added successfully',
            'surgery' => $surgery
        ], 201);
    }
}
