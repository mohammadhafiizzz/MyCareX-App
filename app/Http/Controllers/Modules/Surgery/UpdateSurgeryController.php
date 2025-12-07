<?php

namespace App\Http\Controllers\Modules\Surgery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surgery;
use Illuminate\Support\Facades\Auth;

class UpdateSurgeryController extends Controller
{
    /**
     * Update an existing surgery record
     * 
     * @param Request $request
     * @param Surgery $surgery
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Surgery $surgery) {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Check if the surgery belongs to the authenticated patient
        if ($surgery->patient_id !== $patientId) {
            return response()->json([
                'message' => 'Unauthorized access to this surgery record'
            ], 403);
        }

        // Check if the surgery was created by a doctor (provider)
        if ($surgery->doctor_id !== null) {
            return response()->json([
                'message' => 'You cannot edit records created by healthcare providers'
            ], 403);
        }

        // Validate the request
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

        // Update the surgery record
        $surgery->update($validatedData);

        // Return JSON response
        return response()->json([
            'success' => true,
            'message' => 'Surgery record updated successfully',
            'surgery' => $surgery
        ], 200);
    }
}
