<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentAuthController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.student'); 
    }
}
