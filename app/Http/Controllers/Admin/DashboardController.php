<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\HealthcareProvider;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Show Admin Dashboard
    public function index() {
        // Get total counts
        $totalPatients = Patient::count();
        $totalProviders = HealthcareProvider::count();
        $totalAdmins = Admin::where('role', '!=', 'superadmin')->count();
        $pendingRequests = HealthcareProvider::where('verification_status', 'Pending')->count();

        return view('admin.dashboard', compact(
            'totalPatients',
            'totalProviders', 
            'totalAdmins',
            'pendingRequests'
        ));
    }
}
