<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminManagementController extends Controller
{
    // Show Admin Management Page
    public function index() {
        // default data set (pending admins)
        $admins = $this->queryByStatus('pending')->get();

        // status counters
        $pendingCount  = Admin::whereNull('account_verified_at')
                            ->whereNull('account_rejected_at')
                            ->where('role', '!=', 'superadmin')
                            ->count();

        $approvedCount = Admin::whereNotNull('account_verified_at')
                            ->whereNull('account_rejected_at')
                            ->where('role', '!=', 'superadmin')
                            ->count();

        $rejectedCount = Admin::whereNotNull('account_rejected_at')
                            ->where('role', '!=', 'superadmin')
                            ->count();

        return view('admin.adminManagement', [
            'defaultStatus' => 'pending',
            'admins'        => $admins,
            'pendingCount'  => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
        ]);
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
