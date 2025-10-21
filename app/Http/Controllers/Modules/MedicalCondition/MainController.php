<?php

namespace App\Http\Controllers\Modules\medicalCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    // Show Medical Condition Main Page
    public function index() {
        return view('patient.modules.medicalCondition.medicalCondition');
    }
}
