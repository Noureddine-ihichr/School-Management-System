<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleSlot;
use App\Models\Classe;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['class'])->get();
        return view('admin-section.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $classes = Classe::all();
        $teachers = Teacher::all();
        $subjects = Subject::all();
        return view('admin-section.schedules.create', compact('classes', 'teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'schedule' => 'required|array'
        ]);

        $schedule = Schedule::create([
            'class_id' => $request->class_id
        ]);

        // Flatten the schedule array and create slots
        foreach ($request->schedule as $day => $slots) {
            foreach ($slots as $slot) {
                ScheduleSlot::create([
                    'schedule_id' => $schedule->id,
                    'day' => $day,
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                    'teacher_id' => $slot['teacher_id'],
                    'subject_id' => $slot['subject_id'],
                    'room' => $slot['room']
                ]);
            }
        }

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule created successfully!');
    }

    public function show(Schedule $schedule)
    {
        $schedule->load(['class', 'slots.teacher', 'slots.subject']);
        
        // Define time slots
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
        
        // Get slots grouped by day
        $slotsByDay = [];
        foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day) {
            $daySlots = $schedule->slots->where('day', $day)->map(function($slot) {
                // Convert time to match the time slots in the view
                $startHour = intval(substr($slot->start_time, 0, 2));
                $endHour = intval(substr($slot->end_time, 0, 2));
                
                return [
                    'start_time' => sprintf('%02d:00', $startHour),
                    'end_time' => sprintf('%02d:00', $endHour),
                    'teacher_name' => $slot->teacher->first_name . ' ' . $slot->teacher->last_name,
                    'subject_name' => $slot->subject->name,
                    'room' => $slot->room,
                    'teacher_id' => $slot->teacher_id,
                    'subject_id' => $slot->subject_id
                ];
            })->keyBy('start_time')->toArray();
            
            $slotsByDay[$day] = $daySlots;
        }
        
        return view('admin-section.schedules.show', compact('schedule', 'slotsByDay', 'timeSlots'));
    }

    public function edit(Schedule $schedule)
    {
        $schedule->load(['class', 'slots.teacher', 'slots.subject']);
        
        $classes = Classe::all();
        $teachers = Teacher::all();
        $subjects = Subject::all();
        
        // Format the slots by day ensuring all days are initialized
        $slotsByDay = [];
        foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day) {
            $daySlots = $schedule->slots->where('day', $day)->map(function($slot) {
                // Convert time to match the time slots in the view
                $startHour = intval(substr($slot->start_time, 0, 2));
                $endHour = intval(substr($slot->end_time, 0, 2));
                
                return [
                    'start_time' => sprintf('%02d:00', $startHour),
                    'end_time' => sprintf('%02d:00', $endHour),
                    'teacher_id' => (string)$slot->teacher_id,
                    'subject_id' => (string)$slot->subject_id,
                    'room' => $slot->room
                ];
            })->values()->toArray();
            
            $slotsByDay[$day] = $daySlots;
        }

        return view('admin-section.schedules.edit', 
            compact('schedule', 'classes', 'teachers', 'subjects', 'slotsByDay'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'schedule' => 'required|array'
        ]);

        $schedule->update([
            'class_id' => $request->class_id
        ]);

        // Delete existing slots
        $schedule->slots()->delete();

        // Create new slots with the same structure as store method
        foreach ($request->schedule as $day => $slots) {
            foreach ($slots as $slot) {
                ScheduleSlot::create([
                    'schedule_id' => $schedule->id,
                    'day' => $day,
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                    'teacher_id' => $slot['teacher_id'],
                    'subject_id' => $slot['subject_id'],
                    'room' => $slot['room']
                ]);
            }
        }

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule updated successfully!');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->slots()->delete();
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Schedule deleted successfully!');
    }

    public function downloadPdf(Schedule $schedule)
    {
        $schedule->load(['class', 'slots.teacher', 'slots.subject']);
        
        // Get slots grouped by day
        $slotsByDay = [];
        foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day) {
            $daySlots = $schedule->slots->where('day', $day)->map(function($slot) {
                return [
                    'start_time' => sprintf('%02d:00', intval(substr($slot->start_time, 0, 2))),
                    'end_time' => sprintf('%02d:00', intval(substr($slot->end_time, 0, 2))),
                    'teacher_name' => $slot->teacher->first_name . ' ' . $slot->teacher->last_name,
                    'subject_name' => $slot->subject->name,
                    'room' => $slot->room
                ];
            })->keyBy('start_time')->toArray();
            
            $slotsByDay[$day] = $daySlots;
        }

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

        $pdf = PDF::loadView('admin-section.schedules.pdf', compact('schedule', 'slotsByDay', 'timeSlots'));
        
        return $pdf->download($schedule->class->name . '_schedule.pdf');
    }
}
