<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    // Show the form to add a new teacher
    public function create()
    {
        return view('teachers.create');
    }

    // Save a new teacher
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
        ]);

        // Create the teacher
        Teacher::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'subject' => $request->subject,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully!');
    }

    // List all teachers
    public function index()
    {
        $teachers = Teacher::with('user')->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    // Show the details of a specific teacher
    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }

    // Show the form to edit a teacher
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    // Update a teacher
    public function update(Request $request, Teacher $teacher)
    {
        // Validate the input
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Update the user
        $teacher->user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $teacher->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Update the teacher
        $teacher->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'subject' => $request->subject,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully!');
    }

    // Delete a teacher
    public function destroy(Teacher $teacher)
    {
        // Delete the associated user
        $teacher->user()->delete();

        // Delete the teacher
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully!');

    }

    
}