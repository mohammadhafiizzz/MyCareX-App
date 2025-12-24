<?php

namespace App\Http\Controllers\Modules\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    /* PATIENT METHODS */

    // READ: Show Permission Page (Patient)
    public function patientIndex() {
        $patient = Auth::guard('patient')->user();
        
        // Count providers with granted access
        $totalProvidersWithAccess = Permission::where('patient_id', $patient->id)
            ->where('status', 'Active')
            ->count();
        
        // Count pending access requests
        $pendingRequests = Permission::where('patient_id', $patient->id)
            ->where('status', 'Pending')
            ->count();
        
        return view('patient.modules.permission.permission', compact(
            'totalProvidersWithAccess',
            'pendingRequests'
        ));
    }

    // READ: Show Authorized Doctors List (Patient)
    public function patientDoctors() {
        $patient = Auth::guard('patient')->user();
        
        $doctors = Permission::where('patient_id', $patient->id)
            ->where('status', 'Active')
            ->with(['doctor', 'provider'])
            ->orderBy('granted_at', 'desc')
            ->paginate(10);
        
        return view('patient.modules.permission.doctors', compact('doctors'));
    }

    // READ: Show Pending Access Requests (Patient)
    public function patientRequests() {
        $patient = Auth::guard('patient')->user();
        
        $requests = Permission::where('patient_id', $patient->id)
            ->where('status', 'Pending')
            ->with(['doctor', 'provider'])
            ->orderBy('requested_at', 'desc')
            ->paginate(10);
        
        return view('patient.modules.permission.requests', compact('requests'));
    }

    // READ: Show Confirm Permission Page (Patient)
    public function showConfirmPermission($id) {
        $patient = Auth::guard('patient')->user();
        
        $permission = Permission::where('id', $id)
            ->where('patient_id', $patient->id)
            ->where('status', 'Pending')
            ->with(['doctor', 'provider'])
            ->firstOrFail();
        
        return view('patient.modules.permission.confirmPermission', compact('permission'));
    }

    // READ: Show Full Activity History (Patient)
    public function patientActivity() {
        $patient = Auth::guard('patient')->user();
        
        // For now, return empty collection until tracking tables are implemented
        $activities = collect([]);
        
        return view('patient.modules.permission.activity', compact('activities'));
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
            
            return response()->json([
                'success' => true,
                'message' => 'Access revoked successfully!'
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

    /* DOCTOR METHODS */

    // READ: Show Permission Requests List (Doctor)
    public function doctorIndex(Request $request) {
        $doctor = Auth::guard('doctor')->user();
        $query = trim($request->input('query', ''));

        // Build the base query
        $permissionsQuery = Permission::where('doctor_id', $doctor->id)
            ->with(['patient', 'provider']);

        // Apply search filter if query is provided
        if ($query !== '') {
            $permissionsQuery->whereHas('patient', function($q) use ($query) {
                $q->where('full_name', 'like', '%' . $query . '%')
                  ->orWhere('ic_number', 'like', '%' . $query . '%');
            });
        }

        // Get paginated results
        $permissions = $permissionsQuery->orderBy('requested_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('doctor.modules.permission.requestAccess', [
            'permissions' => $permissions,
            'query' => $query,
        ]);
    }

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
