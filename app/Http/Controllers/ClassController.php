<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    // Show all classes
    public function index()
    {
        $classes = Classe::with('teachers', 'students')->get();
        return view('classes.index', compact('classes'));
    }

    // Show form to create a new class
    public function create()
    {
        $teachers = Teacher::all();
        $students = Student::all();
        return view('classes.create', compact('teachers', 'students'));
    }

    // Store a new class
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teachers' => 'nullable|array',
            'teachers.*' => 'exists:teachers,id',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ]);

        $classe = Classe::create([
            'name' => $request->name,
        ]);

        // Attach teachers to the class
        if ($request->has('teachers')) {
            $classe->teachers()->attach($request->teachers);
        }

        // Attach students to the class
        if ($request->has('students')) {
            $classe->students()->attach($request->students);
        }

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    }

    // Show form to edit a class
    public function edit(Classe $class)
    {
        $teachers = Teacher::all();
        $students = Student::all();
        return view('classes.edit', compact('class', 'teachers', 'students'));
    }

    // Update a class
    public function update(Request $request, Classe $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teachers' => 'nullable|array',
            'teachers.*' => 'exists:teachers,id',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ]);

        $class->update([
            'name' => $request->name,
        ]);

        // Sync teachers for the class
        if ($request->has('teachers')) {
            $class->teachers()->sync($request->teachers);
        }

        // Sync students for the class
        if ($request->has('students')) {
            $class->students()->sync($request->students);
        }

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    // Delete a class
    public function destroy(Classe $class)
    {
        try {
            $class->students()->detach(); // Detach all students
            $class->delete();
            return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('classes.index')->with('error', 'Failed to delete class. Please try again.');
        }
    }

    public function show(Classe $class)
    {
        $class->load('teachers', 'students');
        return view('classes.show', compact('class'));
    }

    public function removeTeacher(Classe $class, Teacher $teacher)
    {
        $class->teachers()->detach($teacher->id);
        return back()->with('success', 'Teacher removed from class successfully.');
    }

    public function removeStudent(Classe $class, Student $student)
    {
        $class->students()->detach($student->id);
        return back()->with('success', 'Student removed from class successfully.');
    }
}