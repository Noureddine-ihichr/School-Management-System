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
        
        // Get teacher's schedule slots
        $scheduleSlots = \App\Models\ScheduleSlot::with(['schedule.class', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->get()
            ->groupBy('day');

        // Define time slots (same as in ScheduleController)
        $timeSlots = [
            '08:00' => '8h à 9h',
            '09:00' => '9h à 10h',
            '10:00' => '10h à 11h',
            '11:00' => '11h à 12h',
            '12:00' => '12h à 13h',
            '13:00' => '13h à 14h',
            '14:00' => '14h à 15h',
            '15:00' => '15h à 16h',
            '16:00' => '16h à 17h',
            '17:00' => '17h à 18h'
        ];

        $stats = [
            'classes' => $teacher->classes()->count(),
            'students' => $teacher->classes()->withCount('students')->get()->sum('students_count'),
            'subjects' => $teacher->subjects()->count(),
            'assignments' => 0 // You can implement this later
        ];

        return view('dashboard.teacher', compact('stats', 'scheduleSlots', 'timeSlots'));
    }
}