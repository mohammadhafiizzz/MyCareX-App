<?php

namespace App\Http\Controllers\Modules\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{
    // CREATE: Request Access to Patient Records (Doctor)
    public function requestAccess(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data provided.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get authenticated doctor
        $doctor = Auth::guard('doctor')->user();

        // Check if there's already an existing permission request
        $existingPermission = Permission::where('patient_id', $request->patient_id)
            ->where('doctor_id', $doctor->id)
            ->whereIn('status', ['Pending', 'Active'])
            ->first();

        if ($existingPermission) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a ' . strtolower($existingPermission->status) . ' permission request for this patient.'
            ], 409);
        }

        // Create new permission request
        try {
            $permission = Permission::create([
                'patient_id' => $request->patient_id,
                'provider_id' => $doctor->provider_id,
                'doctor_id' => $doctor->id,
                'requested_at' => now(),
                'status' => 'Pending',
                'notes' => $request->notes
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Access request sent successfully.',
                'data' => $permission
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send access request. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
