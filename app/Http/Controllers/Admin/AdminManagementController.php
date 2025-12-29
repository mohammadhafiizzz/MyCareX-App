<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminManagementController extends Controller
{
    // Show Admin Management Page (Verified Admins)
    public function index() {
        // Get verified admins (except superadmin)
        $admins = Admin::where('role', '!=', 'superadmin')
            ->whereNotNull('account_verified_at')
            ->orderByDesc('created_at')
            ->get();

        $totalAdmins = $admins->count();

        return view('admin.modules.admin.admin', [
            'admins'      => $admins,
            'totalAdmins' => $totalAdmins,
        ]);
    }

    // Show Pending Admin Requests Page
    public function newRequests() {
        // Get pending admins (except superadmin)
        $admins = Admin::where('role', '!=', 'superadmin')
            ->whereNull('account_verified_at')
            ->whereNull('account_rejected_at')
            ->orderByDesc('created_at')
            ->get();

        $totalAdmins = $admins->count();

        return view('admin.modules.admin.newRequest', [
            'admins'      => $admins,
            'totalAdmins' => $totalAdmins,
        ]);
    }

    // Show Admin Profile Page
    public function adminProfile($id) {
        $admin = Admin::where('admin_id', $id)->firstOrFail();

        return view('admin.modules.admin.adminProfile', compact('admin'));
    }

    // Show Request Info Page (for pending admins)
    public function requestInfo($id) {
        $admin = Admin::where('admin_id', $id)->firstOrFail();

        return view('admin.modules.admin.requestInfo', compact('admin'));
    }

    // get list of admins by status
    public function listAdmins($status) {
        // query based on status
        $collection = $this->queryByStatus($status)->get();

        // return pure data
        return response()->json($collection);
    }

    // query admins by status
    private function queryByStatus($status) {
        return match ($status) {
            'pending'  => Admin::whereNull('account_verified_at')
                            ->whereNull('account_rejected_at')
                            ->where('role', '!=', 'superadmin')
                            ->orderByDesc('created_at'),
            'approved' => Admin::whereNotNull('account_verified_at')
                            ->where('account_rejected_at', null)
                            ->where('role', '!=', 'superadmin')
                            ->orderByDesc('created_at'),
            'rejected' => Admin::whereNotNull('account_rejected_at')
                            ->where('role', '!=', 'superadmin')
                            ->orderByDesc('created_at'),
            default    => Admin::query()->whereRaw('0 = 1'),
        };
    }

    private function counters() {
        return [
            'pending'  => Admin::whereNull('account_verified_at')
                            ->whereNull('account_rejected_at')
                            ->where('role', '!=', 'superadmin')
                            ->count(),
            'approved' => Admin::whereNotNull('account_verified_at')
                            ->whereNull('account_rejected_at')
                            ->where('role', '!=', 'superadmin')
                            ->count(),
            'rejected' => Admin::whereNotNull('account_rejected_at')
                            ->where('role', '!=', 'superadmin')
                            ->count(),
        ];
    }

    // Approve admin account
    public function approveAdmin(Admin $admin) {
        $admin->update([
            'account_verified_at' => now(),
            'account_rejected_at' => null,
            'account_verified_by' => Auth::guard('admin')->user()->admin_id,
        ]);

        return response()->json(['ok' => true, 'message' => 'Admin account approved successfully.', 'type' => 'success', 'counts' => $this->counters()]);
    }

    // Reject admin account
    public function rejectAdmin(Admin $admin) {
        $admin->update([
            'account_rejected_at' => now(),
            'account_verified_at' => null,
            'account_verified_by' => Auth::guard('admin')->user()->admin_id,
        ]);

        return response()->json(['ok' => true, 'message' => 'Admin account rejected successfully.', 'type' => 'error', 'counts' => $this->counters()]);
    }

    // Delete admin account
    public function deleteAdmin(Admin $admin) {
        $admin->delete();

        return response()->json(['ok' => true, 'message' => 'Admin account deleted successfully.', 'type' => 'error', 'counts' => $this->counters()]);
    }
}
