<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Show Organisation Dashboard
    public function index() {
        $organisation = auth()->guard('organisation')->user();
        $isVerified = $organisation && $organisation->verification_status === 'Approved';

        return view('organisation.dashboard', compact('organisation', 'isVerified'));
    }

    public function addDoctor() {
        $organisation = auth()->guard('organisation')->user();
        $isVerified = $organisation && $organisation->verification_status === 'Approved';

        return view('organisation.modules.doctor.addDoctor', compact('organisation', 'isVerified'));
    }

    public function profile() {
        $organisation = auth()->guard('organisation')->user();
        return view('organisation.profile', compact('organisation'));
    }

    public function settings() {
        $organisation = auth()->guard('organisation')->user();
        return view('organisation.settings', compact('organisation'));
    }
}
