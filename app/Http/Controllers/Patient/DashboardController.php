<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Define route for patient dashboard
    public function index() {
        return view('patient.dashboard');
    }

    // Define route for my records
    public function myRecords() {
        return view('patient.myrecords');
    }
}
