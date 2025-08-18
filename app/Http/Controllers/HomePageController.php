<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller {
    // show MyCareX home page
    public function index() {
        return view('index');
    }
}

?>