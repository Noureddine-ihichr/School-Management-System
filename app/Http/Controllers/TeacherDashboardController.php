<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    // Show the teacher dashboard
    public function dashboard()
    {
        $teacher = auth()->user()->teacher;
        
        $stats = [
            'classes' => $teacher->classes()->count(),
            'students' => $teacher->classes()->withCount('students')->get()->sum('students_count'),
            'subjects' => $teacher->subjects()->count(),
            'assignments' => 0, // You'll need to implement this once you have the assignments feature
        ];

        return view('dashboard.teacher', compact('stats'));
    }
}