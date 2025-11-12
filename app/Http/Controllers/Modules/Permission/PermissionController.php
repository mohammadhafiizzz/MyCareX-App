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
        
        // For now, return empty array for activities until the tracking tables are implemented
        $recentActivities = [];
        
        return view('patient.modules.permission.permission', compact(
            'totalProvidersWithAccess',
            'pendingRequests',
            'recentActivities'
        ));
    }
    
    // Show all providers with access
    public function providers() {
        $patient = Auth::guard('patient')->user();
        
        $providers = Permission::where('patient_id', $patient->id)
            ->where('status', 'Active')
            ->with('provider')
            ->orderBy('granted_at', 'desc')
            ->paginate(10);
        
        return view('patient.modules.permission.providers', compact('providers'));
    }
    
    // Show pending access requests
    public function requests() {
        $patient = Auth::guard('patient')->user();
        
        $requests = Permission::where('patient_id', $patient->id)
            ->where('status', 'Pending')
            ->with('provider')
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
}
