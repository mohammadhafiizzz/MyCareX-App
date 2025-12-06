<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Define route for patient pages

    // 1. Dashboard
    public function index() {
        return view('patient.dashboard');
    }

    // 2. Medical History
    public function medicalHistory() {
        return view('patient.medicalHistory');
    }
}