<?php

namespace App\Http\Controllers\Modules\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    // index
    public function index() {
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
    
    // Show all providers with access
    public function doctors() {
        $patient = Auth::guard('patient')->user();
        
        $doctors = Permission::where('patient_id', $patient->id)
            ->where('status', 'Active')
            ->with(['doctor', 'provider'])
            ->orderBy('granted_at', 'desc')
            ->paginate(10);
        
        return view('patient.modules.permission.doctors', compact('doctors'));
    }
    
    // Show pending access requests
    public function requests() {
        $patient = Auth::guard('patient')->user();
        
        $requests = Permission::where('patient_id', $patient->id)
            ->where('status', 'Pending')
            ->with(['doctor', 'provider'])
            ->orderBy('requested_at', 'desc')
            ->paginate(10);
        
        return view('patient.modules.permission.requests', compact('requests'));
    }
    
    // Show full activity history
    public function activity() {
        $patient = Auth::guard('patient')->user();
        
        // For now, return empty collection until tracking tables are implemented
        $activities = collect([]);
        
        return view('patient.modules.permission.activity', compact('activities'));
    }
    
    // Approve access request
    public function approve(Request $request, $id) {
        try {
            $patient = Auth::guard('patient')->user();
            
            // Find the permission request
            $permission = Permission::where('id', $id)
                ->where('patient_id', $patient->id)
                ->where('status', 'Pending')
                ->firstOrFail();
            
            // Validate expiry date
            $request->validate([
                'expiry_date' => 'required|date|after:today'
            ]);
            
            // Update permission
            $permission->update([
                'granted_at' => now(),
                'status' => 'Active',
                'expiry_date' => $request->expiry_date,
                // Keep existing permission_scope or set default if none exists
                'permission_scope' => $permission->permission_scope ?? ['all']
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
                'message' => 'Invalid expiry date. Please select a future date.',
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
