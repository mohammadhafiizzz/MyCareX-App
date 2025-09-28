<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Models\HealthcareProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProviderManagementController extends Controller
{
    // Show healthcare provider list page
    public function index() {
        // Get all providers
        $providers = HealthcareProvider::where('verification_status', 'Approved')->orderByDesc('created_at')->get();

        return view('admin.modules.healthcareProvider.providerManagement', ['providers' => $providers, 'defaultStatus' => 'approved', 'providerCount' => $this->counters()['approved'], 'requestCount' => $this->counters()['pending']]);
    }

    // Show healthcare provider request list page
    public function providerVerification() {
        // default data set (pending providers)
        $providers = $this->queryByStatus('pending')->get();

        // status counters
        $pendingCount  = HealthcareProvider::where('verification_status', 'Pending')->count();
        $approvedCount = HealthcareProvider::where('verification_status', 'Approved')->count();
        $rejectedCount = HealthcareProvider::where('verification_status', 'Rejected')->count();

        return view('admin.modules.healthcareProvider.providerVerification', [
            'defaultStatus' => 'pending',
            'providers'     => $providers,
            'pendingCount'  => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
        ]);
    }

    // get list of providers by status
    public function listProviders($status) {
        // query based on status
        $collection = $this->queryByStatus($status)->get();

        // return pure data
        return response()->json($collection);
    }

    private function queryByStatus($status) {
        return match (strtolower($status)) {
            'pending'  => HealthcareProvider::where('verification_status', 'Pending')
                            ->orderByDesc('created_at'),
            'approved' => HealthcareProvider::where('verification_status', 'Approved')
                            ->orderByDesc('created_at'),
            'rejected' => HealthcareProvider::where('verification_status', 'Rejected')
                            ->orderByDesc('created_at'),
            default    => HealthcareProvider::where('verification_status', 'Pending')
                            ->orderByDesc('created_at'),
        };
    }

    // status counters
    private function counters() {
        return [
            'pending'  => HealthcareProvider::where('verification_status', 'Pending')->count(),
            'approved' => HealthcareProvider::where('verification_status', 'Approved')->count(),
            'rejected' => HealthcareProvider::where('verification_status', 'Rejected')->count(),
        ];
    }

    // Approve a healthcare provider
    public function approveProvider(HealthcareProvider $provider) {
        $provider->update([
            'verification_status' => 'Approved',
            'verified_by' => Auth::guard('admin')->user()->admin_id,
            'approved_at' => now(),
            'rejected_at' => null,
            'rejection_reason' => null,
        ]);

        return response()->json(['ok' => true, 'message' => 'Healthcare provider approved successfully.', 'type' => 'success', 'counts' => $this->counters()]);
    }

    // Reject a healthcare provider
    public function rejectProvider(Request $request, HealthcareProvider $provider) {
        $provider->update([
            'verification_status' => 'Rejected',
            'verified_by' => Auth::guard('admin')->user()->admin_id,
            'rejected_at' => now(),
            'rejection_reason' => $request->input('reason'),
        ]);

        return response()->json(['ok' => true, 'message' => 'Healthcare provider rejected successfully.', 'type' => 'success', 'counts' => $this->counters()]);
    }

    // Delete a healthcare provider
    public function deleteProvider(HealthcareProvider $provider) {
        $provider->delete();

        return response()->json(['ok' => true, 'message' => 'Healthcare provider deleted successfully.', 'type' => 'success', 'counts' => $this->counters()]);
    }
}
