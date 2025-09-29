<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Show Organisation Dashboard
    public function index() {
        return view('organisation.dashboard');
    }
}
