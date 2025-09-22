<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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
        $pendingAdmins = Admin::where('account_verified_at')
            ->where('role', '!=', 'super_admin')
            ->orderBy('created_at', 'desc')
            ->get();

        
    }
}
