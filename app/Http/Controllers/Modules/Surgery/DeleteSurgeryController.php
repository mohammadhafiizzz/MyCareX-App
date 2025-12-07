<?php

namespace App\Http\Controllers\Modules\Surgery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surgery;
use Illuminate\Support\Facades\Auth;

class DeleteSurgeryController extends Controller
{
    /**
     * Delete a surgery record
     * 
     * @param Surgery $surgery
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Surgery $surgery) {
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
                'message' => 'You cannot delete records created by healthcare providers'
            ], 403);
        }

        // Delete the surgery
        $surgery->delete();

        // Redirect to surgery page with success message
        return redirect()->route('patient.surgery')->with('message', 'Surgery record deleted successfully');
    }
}
