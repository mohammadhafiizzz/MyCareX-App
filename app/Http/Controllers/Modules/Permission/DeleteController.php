<?php

namespace App\Http\Controllers\Modules\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    // DELETE: Decline Access Request (Patient)
    public function declineRequest($id) {
        try {
            $patient = Auth::guard('patient')->user();
            
            // Find the permission request
            $permission = Permission::where('id', $id)
                ->where('patient_id', $patient->id)
                ->where('status', 'Pending')
                ->firstOrFail();
            
            // Delete the permission record
            $permission->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Access request declined successfully!'
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permission request not found.'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while declining the request.'
            ], 500);
        }
    }

    // DELETE: Revoke Permission (Patient)
    public function revokePermission(Request $request) {
        try {
            $patient = Auth::guard('patient')->user();
            
            // Validate request data
            $request->validate([
                'provider_id' => 'required|exists:healthcare_providers,id',
                'doctor_id' => 'required|exists:doctors,id',
                'confirmation' => 'required|string|in:REVOKE'
            ]);

            // Find the permission using patient_id, provider_id, and doctor_id
            $permission = Permission::where('patient_id', $patient->id)
                ->where('provider_id', $request->provider_id)
                ->where('doctor_id', $request->doctor_id)
                ->where('status', 'Active')
                ->firstOrFail();
            
            // Delete the permission record
            $permission->delete();

            session()->flash('success', 'Access revoked successfully!');
            
            return response()->json([
                'success' => true,
                'message' => 'Access revoked successfully!',
                'redirect' => route('patient.permission')
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permission record not found.'
            ], 404);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()['confirmation'][0] ?? 'Invalid data provided.',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while revoking access.'
            ], 500);
        }
    }

    // DELETE: Terminate Access (Doctor)
    public function terminateAccess($id) {
        try {
            $doctor = Auth::guard('doctor')->user();
            
            // Find the permission record
            $permission = Permission::where('id', $id)
                ->where('doctor_id', $doctor->id)
                ->where('status', 'Active')
                ->firstOrFail();
            
            // Delete the permission record
            $permission->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Access terminated successfully!',
                'redirect' => route('doctor.patients')
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permission record not found.'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while terminating access.'
            ], 500);
        }
    }
}
