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
        return view('admin-section.classes.index', compact('classes'));
    }

    // Show form to create a new class
    public function create()
    {
        $teachers = Teacher::all();
        $students = Student::all();
        return view('admin-section.classes.create', compact('teachers', 'students'));
    }

    // Store a new class
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teachers' => 'nullable|array',
            'teachers.*' => 'exists:teachers,id',
            'teacher_subjects' => 'nullable|array',
            'teacher_subjects.*' => 'array',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id'
        ]);

        $class = Classe::create([
            'name' => $request->name,
        ]);

        // Attach teachers and their subjects
        if ($request->has('teachers')) {
            $class->teachers()->attach($request->teachers);

            // Attach subjects for each teacher
            foreach ($request->teacher_subjects ?? [] as $teacherId => $subjectIds) {
                foreach ($subjectIds as $subjectId) {
                    $class->subjects()->attach($subjectId, ['teacher_id' => $teacherId]);
                }
            }
        }

        // Attach students to the class
        if ($request->has('students')) {
            $class->students()->attach($request->students);
        }

        return redirect()->route('classes.index')
            ->with('success', 'Class created successfully.');
    }

    // Show form to edit a class
    public function edit(Classe $class)
    {
        $teachers = Teacher::all();
        $students = Student::all();
        return view('admin-section.classes.edit', compact('class', 'teachers', 'students'));
    }

    // Update a class
    public function update(Request $request, Classe $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teachers' => 'nullable|array',
            'teachers.*' => 'exists:teachers,id',
            'teacher_subjects' => 'nullable|array',
            'teacher_subjects.*' => 'array'
        ]);

        $class->update([
            'name' => $request->name,
        ]);

        // Sync teachers
        $class->teachers()->sync($request->teachers ?? []);

        // Detach all existing subject-teacher relationships
        $class->subjects()->detach();

        // Attach new subject-teacher relationships
        foreach ($request->teacher_subjects ?? [] as $teacherId => $subjectIds) {
            foreach ($subjectIds as $subjectId) {
                $class->subjects()->attach($subjectId, ['teacher_id' => $teacherId]);
            }
        }

        return redirect()->route('classes.index')
            ->with('success', 'Class updated successfully.');
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
        return view('admin-section.classes.show', compact('class'));
    }

    public function removeTeacher(Classe $class, Teacher $teacher)
    {
        try {
            $class->teachers()->detach($teacher->id);
            return back()->with('success', 'Teacher removed from class successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove teacher.');
        }
    }

    public function removeStudent(Classe $class, Student $student)
    {
        try {
            $class->students()->detach($student->id);
            return back()->with('success', 'Student removed from class successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to remove student.');
        }
    }

    public function teacherClassDetails(Classe $class)
    {
        // Get the logged-in teacher
        $teacher = auth()->user()->teacher;

        // Load all necessary relationships
        $class->load(['teachers', 'students', 'subjects']);

        // Ensure the teacher is assigned to this class
        if (!$class->teachers->contains($teacher)) {
            abort(403, 'You are not assigned to this class.');
        }

        // Get paginated students
        $students = $class->students()->paginate(7);
        
        // Get subjects taught by this teacher in this class
        $subjects = $class->subjects()
            ->wherePivot('teacher_id', $teacher->id)
            ->get();

        return view('teacher-section.classes.show', compact('class', 'subjects', 'students'));
    }
}