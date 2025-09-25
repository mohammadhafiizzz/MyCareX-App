<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    // Show Organisation Home Page
    public function index() {
        return view('organisation.homePage');
    }
}
