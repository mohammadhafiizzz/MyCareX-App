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
        return view('admin.adminManagement');
    }

    // Get list of admins

    // Get pending admin verifications
    public function getPendingAdmins() {
        // Logic to fetch pending verifications
        $pendingAdmins = Admin::whereNull('account_verified_at')
            ->where('role', '!=', 'super_admin')
            ->orderBy('created_at', 'desc')
            ->get();
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
