<?php

namespace App\Http\Controllers\Modules\Hospitalisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospitalisation;
use Illuminate\Support\Facades\Auth;

class AddHospitalisationController extends Controller
{
    /**
     * Add a new hospitalisation record
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) {
        // Get authenticated patient id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
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

        // Create the hospitalisation record
        $hospitalisation = Hospitalisation::create([
            'patient_id' => $patientId,
            'doctor_id' => null, // Patient-created records have no doctor_id
            'admission_date' => $validated['admission_date'],
            'discharge_date' => $validated['discharge_date'] ?? null,
            'reason_for_admission' => $validated['reason_for_admission'],
            'provider_name' => $validated['provider_name'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'verification_status' => false,
        ]);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Hospitalisation record added successfully',
            'hospitalisation' => $hospitalisation
        ], 201);
    }
}
