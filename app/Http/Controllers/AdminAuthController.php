<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.admin'); 
    }
}
