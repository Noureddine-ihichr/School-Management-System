<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    // Show the teacher dashboard
    public function dashboard()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get the associated teacher
        $teacher = $user->teacher;

        // Pass the teacher data to the dashboard view
        return view('dashboard.teacher', compact('teacher'));
    }
}