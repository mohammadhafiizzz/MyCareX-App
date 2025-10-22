<?php

namespace App\Http\Controllers\Modules\Medication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    // Show medication page
    public function index() {
        return view('patient.modules.medication.medication');
    }
}
