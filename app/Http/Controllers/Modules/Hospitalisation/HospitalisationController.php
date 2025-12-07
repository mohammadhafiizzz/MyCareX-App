<?php

namespace App\Http\Controllers\Modules\Hospitalisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospitalisation;
use Illuminate\Support\Facades\Auth;

class HospitalisationController extends Controller
{
    // main page
    public function index() {

        // get authenticated user id
        $patientId = Auth::guard('patient')->id() ?? Auth::id();
        if (!$patientId) {
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // retrieve hospitalisation records for the patient
        $hospitalisations = Hospitalisation::where('patient_id', $patientId)
            ->select('id', 'admission_date', 'discharge_date', 'reason_for_admission', 'provider_name', 'doctor_id', 'verification_status', 'created_at', 'updated_at')
            ->orderBy('admission_date', 'desc')
            ->get();

        // get last updated hospitalisation
        $lastUpdatedHospitalisation = $hospitalisations->sortByDesc(function($hospitalisation) {
            return $hospitalisation->updated_at ?? $hospitalisation->created_at;
        })->first();

        return view("patient.modules.hospitalisation.hospitalisation", compact('hospitalisations', 'lastUpdatedHospitalisation'));
    }

    /**
     * Get hospitalisation data as JSON for editing
     * 
     * @param Hospitalisation $hospitalisation
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHospitalisationJson(Hospitalisation $hospitalisation) {
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

        // Return hospitalisation data
        return response()->json([
            'success' => true,
            'hospitalisation' => $hospitalisation
        ], 200);
    }

    /**
     * Show hospitalisation more info page
     * 
     * @param Hospitalisation $hospitalisation
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function moreInfo(Hospitalisation $hospitalisation) {
        // Policy/Gate check: Ensure this hospitalisation belongs to the authenticated patient
        if ($hospitalisation->patient_id !== Auth::guard('patient')->id()) {
            return redirect()->route('patient.hospitalisation')->with('error', 'Unauthorized access to hospitalisation.');
        }

        // Process styling data for the hospitalisation
        $verificationStatus = $hospitalisation->verification_status ? 'Verified' : 'Not Verified';
        $isProviderCreated = $hospitalisation->doctor_id !== null;

        $verificationBadgeStyles = $hospitalisation->verification_status
            ? 'bg-green-100 text-green-700 border border-green-200'
            : 'bg-gray-100 text-gray-600 border border-gray-200';

        $verificationIcon = $hospitalisation->verification_status
            ? 'fas fa-check-circle'
            : 'fas fa-circle';

        $admissionDateLabel = $hospitalisation->admission_date ? $hospitalisation->admission_date->format('F d, Y') : 'Not scheduled';
        $dischargeDateLabel = $hospitalisation->discharge_date ? $hospitalisation->discharge_date->format('F d, Y') : 'Not discharged yet';
        $createdLabel = $hospitalisation->created_at ? $hospitalisation->created_at->format('F d, Y') : 'Unknown';
        $updatedLabel = $hospitalisation->updated_at ? $hospitalisation->updated_at->diffForHumans() : 'Never';

        return view('patient.modules.hospitalisation.moreInfo', [
            'hospitalisation' => $hospitalisation,
            'verificationBadgeStyles' => $verificationBadgeStyles,
            'verificationIcon' => $verificationIcon,
            'verificationStatus' => $verificationStatus,
            'isProviderCreated' => $isProviderCreated,
            'admissionDateLabel' => $admissionDateLabel,
            'dischargeDateLabel' => $dischargeDateLabel,
            'createdLabel' => $createdLabel,
            'updatedLabel' => $updatedLabel,
        ]);
    }
}
