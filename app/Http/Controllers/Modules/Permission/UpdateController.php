<?php

namespace App\Http\Controllers\Modules\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{
    // UPDATE: Update Permission Scope (Patient)
    public function updatePermission(Request $request, $id) {
        try {
            $patient = Auth::guard('patient')->user();
            
            // Find the active permission
            $permission = Permission::where('id', $id)
                ->where('patient_id', $patient->id)
                ->where('status', 'Active')
                ->firstOrFail();
            
            // Validate expiry date and scope
            $request->validate([
                'expiry_date' => 'required|date|after:today',
                'permission_scope' => 'required|array|min:1'
            ]);
            
            // Update permission
            $permission->update([
                'expiry_date' => $request->expiry_date,
                'permission_scope' => $request->permission_scope
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Access scope updated successfully!',
                'permission' => $permission
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permission record not found.'
            ], 404);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()['expiry_date'][0] ?? $e->errors()['permission_scope'][0] ?? 'Invalid data provided.',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the request.'
            ], 500);
        }
    }

    // UPDATE: Approve Access Request (Patient)
    public function approveRequest(Request $request, $id) {
        try {
            $patient = Auth::guard('patient')->user();
            
            // Find the permission request
            $permission = Permission::where('id', $id)
                ->where('patient_id', $patient->id)
                ->where('status', 'Pending')
                ->firstOrFail();
            
            // Validate expiry date and scope
            $request->validate([
                'expiry_date' => 'required|date|after:today',
                'permission_scope' => 'required|array|min:1'
            ]);
            
            // Update permission
            $permission->update([
                'granted_at' => now(),
                'status' => 'Active',
                'expiry_date' => $request->expiry_date,
                'permission_scope' => $request->permission_scope
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Access granted successfully!',
                'permission' => $permission
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permission request not found or already processed.'
            ], 404);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->errors()['expiry_date'][0] ?? $e->errors()['permission_scope'][0] ?? 'Invalid data provided.',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the request.'
            ], 500);
        }
    }
}
