<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HealthcareProvider;
use App\Models\Doctor;

class ProviderManagementController extends Controller {
    
    // READ: Show Healthcare Provider List
    public function provider() {
        // Get authenticated organisation id
        $adminId = Auth::guard('admin')->id() ?? Auth::id();

        // Check if the organisation is verified
        $admin = Auth::guard('admin')->user();
        $isVerified = $admin && $admin->account_verified_at !== null;

        // Check if organisation is authenticated
        if (!$adminId) {
            return redirect()->route('admin.login');
        }

        // Get healthcare providers associated with the admin
        $providers = HealthcareProvider::orderBy('created_at', 'desc')->get();

        $totalProviders = $providers->count();
        return view('admin.modules.healthcareProvider.provider', compact('providers', 'isVerified', 'totalProviders'));
    }

    // READ: Show Pending Healthcare Provider Requests
    public function requests() {
        // Get authenticated organisation id
        $adminId = Auth::guard('admin')->id() ?? Auth::id();

        // Check if the organisation is verified
        $admin = Auth::guard('admin')->user();
        $isVerified = $admin && $admin->account_verified_at !== null;

        // Get healthcare providers with Pending and Rejected status
        $providers = HealthcareProvider::whereIn('verification_status', ['Pending', 'Rejected'])
            ->orderByRaw("CASE WHEN verification_status = 'Pending' THEN 1 ELSE 2 END")
            ->orderBy('created_at', 'desc')
            ->get();

        $totalProviders = $providers->count();
        return view('admin.modules.healthcareProvider.requestList', compact('providers', 'isVerified', 'totalProviders'));
    }

    // READ: Show Healthcare Provider Verification Details
    public function providerVerification($id) {
        $healthcareProvider = HealthcareProvider::findOrFail($id);

        // Check if the admin is verified
        $admin = Auth::guard('admin')->user();
        $isVerified = $admin && $admin->account_verified_at !== null;

        return view('admin.modules.healthcareProvider.providerVerification', compact('healthcareProvider', 'isVerified'));
    }

    // READ: Show Healthcare Provider Profile
    public function viewProfile($id) {
        $organisation = HealthcareProvider::findOrFail($id);
        $admin = Auth::guard('admin')->user();
        $isVerified = $organisation->verification_status === 'Approved';

        return view('admin.modules.healthcareProvider.providerProfile', compact('organisation', 'isVerified'));
    }

    // UPDATE: Approve Healthcare Provider Request
    public function approve($id) {
        $provider = HealthcareProvider::findOrFail($id);
        $provider->update(['verification_status' => 'Approved']);

        return redirect()->back()->with('success', 'Healthcare provider approved successfully.');
    }

    // UPDATE: Reject Healthcare Provider Request
    public function reject($id) {
        $provider = HealthcareProvider::findOrFail($id);
        $provider->update(['verification_status' => 'Rejected']);

        return redirect()->route('admin.providers.requests')->with('success', 'Healthcare provider rejected successfully.');
    }

    // DELETE: Remove Healthcare Provider
    public function deleteProvider(HealthcareProvider $provider) {
        $provider->delete();

        return redirect()->route('admin.providers')->with('success', 'Healthcare provider removed successfully.');
    }
}