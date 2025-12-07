<?php

namespace App\Http\Controllers\Modules\Surgery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surgery;
use Illuminate\Support\Facades\Auth;

class SurgeryController extends Controller
{
    // main page
    public function index() {

        // get authenticated user id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // retrieve surgery records for the patient
        $surgeries = Surgery::where('patient_id', $patientId)
            ->select('id', 'procedure_name', 'procedure_date', 'surgeon_name', 'hospital_name', 'doctor_id', 'verification_status', 'created_at', 'updated_at')
            ->orderBy('procedure_date', 'desc')
            ->get();

        // get last updated surgery
        $lastUpdatedSurgery = $surgeries->sortByDesc(function($surgery) {
            return $surgery->updated_at ?? $surgery->created_at;
        })->first();

        return view("patient.modules.surgery.surgery", compact('surgeries', 'lastUpdatedSurgery'));
    }

    /**
     * Get surgery data as JSON for editing
     * 
     * @param Surgery $surgery
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSurgeryJson(Surgery $surgery) {
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

        // Return surgery data
        return response()->json([
            'success' => true,
            'surgery' => $surgery
        ], 200);
    }
}
