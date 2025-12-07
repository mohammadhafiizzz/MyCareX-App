<?php

namespace App\Http\Controllers\Modules\Hospitalisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospitalisation;
use Illuminate\Support\Facades\Auth;

class UpdateHospitalisationController extends Controller
{
    /**
     * Update a hospitalisation record
     * 
     * @param Request $request
     * @param Hospitalisation $hospitalisation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Hospitalisation $hospitalisation) {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Check if the hospitalisation belongs to the authenticated patient
        if ($hospitalisation->patient_id !== $patientId) {
            return response()->json([
                'message' => 'Unauthorized access to this hospitalisation record'
            ], 403);
        }

        // Check if the hospitalisation was created by a doctor (provider)
        if ($hospitalisation->doctor_id !== null) {
            return response()->json([
                'message' => 'You cannot edit records created by healthcare providers'
            ], 403);
        }

        // Validate the request
        $validated = $request->validate([
            'admission_date' => 'required|date|before_or_equal:today',
            'discharge_date' => 'nullable|date|after_or_equal:admission_date',
            'reason_for_admission' => 'required|string|max:255',
            'provider_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ], [
            'admission_date.required' => 'Admission date is required.',
            'admission_date.before_or_equal' => 'Admission date cannot be in the future.',
            'discharge_date.after_or_equal' => 'Discharge date must be after admission date.',
            'reason_for_admission.required' => 'Reason for admission is required.',
        ]);

        // Update the hospitalisation record
        $hospitalisation->update([
            'admission_date' => $validated['admission_date'],
            'discharge_date' => $validated['discharge_date'] ?? null,
            'reason_for_admission' => $validated['reason_for_admission'],
            'provider_name' => $validated['provider_name'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Hospitalisation record updated successfully',
            'hospitalisation' => $hospitalisation
        ], 200);
    }
}
