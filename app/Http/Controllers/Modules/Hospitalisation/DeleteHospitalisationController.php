<?php

namespace App\Http\Controllers\Modules\Hospitalisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospitalisation;
use Illuminate\Support\Facades\Auth;

class DeleteHospitalisationController extends Controller
{
    /**
     * Delete a hospitalisation record
     * 
     * @param Hospitalisation $hospitalisation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Hospitalisation $hospitalisation) {
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
                'message' => 'You cannot delete records created by healthcare providers'
            ], 403);
        }

        // Delete the hospitalisation
        $hospitalisation->delete();

        // Redirect to hospitalisation page with success message
        return redirect()->route('patient.hospitalisation')->with('message', 'Hospitalisation record deleted successfully');
    }
}
