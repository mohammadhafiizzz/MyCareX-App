<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // show dashboard
    public function index() {
        return view('doctor.dashboard');
    }

    // search patient page
    public function searchPatient() {
        return view('doctor.modules.patient.searchPatient');
    }
}
