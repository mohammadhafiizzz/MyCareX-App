<?php

namespace App\Http\Controllers\Modules\Hospitalisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HospitalisationController extends Controller
{
    // hospitalisation main page
    public function index() {
        return view('modules.hospitalisation.hospitalisation');
    }
}
