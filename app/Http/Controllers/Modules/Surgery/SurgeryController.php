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

    /**
     * Show surgery more info page
     * 
     * @param Surgery $surgery
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function moreInfo(Surgery $surgery) {
        // Policy/Gate check: Ensure this surgery belongs to the authenticated patient
        if ($surgery->patient_id !== Auth::guard('patient')->id()) {
            return redirect()->route('patient.surgery')->with('error', 'Unauthorized access to surgery.');
        }

        // Process styling data for the surgery
        $verificationStatus = $surgery->verification_status ? 'Verified' : 'Not Verified';
        $isProviderCreated = $surgery->doctor_id !== null;

        $verificationBadgeStyles = $surgery->verification_status
            ? 'bg-green-100 text-green-700 border border-green-200'
            : 'bg-gray-100 text-gray-600 border border-gray-200';

        $verificationIcon = $surgery->verification_status
            ? 'fas fa-check-circle'
            : 'fas fa-circle';

        $procedureDateLabel = $surgery->procedure_date ? $surgery->procedure_date->format('F d, Y') : 'Not scheduled';
        $createdLabel = $surgery->created_at ? $surgery->created_at->format('F d, Y') : 'Unknown';
        $updatedLabel = $surgery->updated_at ? $surgery->updated_at->diffForHumans() : 'Never';

        return view('patient.modules.surgery.moreInfo', [
            'surgery' => $surgery,
            'verificationBadgeStyles' => $verificationBadgeStyles,
            'verificationIcon' => $verificationIcon,
            'verificationStatus' => $verificationStatus,
            'isProviderCreated' => $isProviderCreated,
            'procedureDateLabel' => $procedureDateLabel,
            'createdLabel' => $createdLabel,
            'updatedLabel' => $updatedLabel,
        ]);
    }
}
