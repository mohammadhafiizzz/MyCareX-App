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

        // default is pending
        $admins = $this->queryByStatus('pending')->get();

        return view('admin.adminManagement', [
            'defaultStatus' => 'pending',
            'admins' => $admins,
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
                            ->where('role', '!=', 'super_admin')
                            ->orderByDesc('created_at'),
            'approved' => Admin::whereNotNull('account_verified_at')
                            ->where('account_rejected_at', null)
                            ->where('role', '!=', 'super_admin')
                            ->orderByDesc('created_at'),
            'rejected' => Admin::whereNotNull('account_rejected_at')
                            ->where('role', '!=', 'super_admin')
                            ->orderByDesc('created_at'),
            default    => Admin::query()->whereRaw('0 = 1'),
        };
    }

    // Approve admin account
    public function approve(Request $request, $adminId)
    {
        $admin = Admin::where('admin_id', $adminId)->first();
        
        if (!$admin) {
            return back()->with('error', 'Admin not found.');
        }

        $admin->update([
            'account_verified_at' => now(),
            'account_verified_by' => Auth::guard('admin')->user()->admin_id
        ]);

        return redirect()->route('admin.management', ['status' => 'approved'])
            ->with('success', 'Admin account approved successfully.');
    }
}
