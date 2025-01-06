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
        $classes = Classe::with('teacher', 'students')->get();
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
            'teacher_id' => 'nullable|exists:teachers,id',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ]);

        $classe = Classe::create([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
        ]);

        // Attach students to the class
        if ($request->has('students')) {
            $classe->students()->attach($request->students);
        }

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
    }

    // Show form to edit a class
    public function edit(Classe $classe)
    {
        $teachers = Teacher::all();
        $students = Student::all();
        return view('classes.edit', compact('classe', 'teachers', 'students'));
    }

    // Update a class
    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:teachers,id',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ]);

        $classe->update([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
        ]);

        // Sync students for the class
        if ($request->has('students')) {
            $classe->students()->sync($request->students);
        }

        return redirect()->route('classes.index')->with('success', 'Classe updated successfully.');
    }

    // Delete a class
    public function destroy(Classe $classe)
    {
        $classe->students()->detach(); // Detach all students
        $classe->delete();
        return redirect()->route('classes.index')->with('success', 'Classe deleted successfully.');
    }
}