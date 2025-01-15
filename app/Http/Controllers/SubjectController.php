<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve subjects with teacher count and pagination
        $subjects = Subject::withCount('teachers')->paginate(10);
    
        // Pass subjects to the view
        return view('admin-section.subjects.index', compact('subjects'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::all();
        return view('admin-section.subjects.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|unique:subjects',
            'code' => 'required|unique:subjects',
            'description' => 'required',
            'teachers' => 'required|array',
            'teachers.*' => 'exists:teachers,id'
        ]);

        try {
            // Create the subject
            $subject = Subject::create([
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
            ]);

            // Attach teachers to the subject
            $subject->teachers()->attach($request->teachers);

            // Redirect to subjects.index instead of admin-section.subjects.index
            return redirect()->route('subjects.index')->with('success', 'Subject created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating subject: ' . $e->getMessage());
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Retrieve the subject by its ID with teachers relationship
        $subject = Subject::with('teachers')->findOrFail($id);
    
        // Pass the subject data to the view
        return view('admin-section.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the subject by its ID
        $subject = Subject::findOrFail($id);
        
        // Get all teachers for the selection
        $teachers = Teacher::all();

        // Pass the subject and teachers data to the view
        return view('admin-section.subjects.edit', compact('subject', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|unique:subjects,name,' . $id . '|max:255',
            'code' => 'nullable|unique:subjects,code,' . $id . '|max:50',
            'description' => 'nullable|string',
            'teachers' => 'nullable|array',
            'teachers.*' => 'exists:teachers,id'
        ]);
    
        // Find the subject by ID
        $subject = Subject::findOrFail($id);
        
        // Update basic subject information
        $subject->update([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'description' => $validated['description']
        ]);
        
        // Sync teachers if any are selected
        if ($request->has('teachers')) {
            $subject->teachers()->sync($request->teachers);
        } else {
            $subject->teachers()->detach();
        }
    
        // Changed from admin-section.subjects.index to subjects.index
        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the subject by its ID and delete it
        $subject = Subject::findOrFail($id);
        $subject->delete();

        // Changed from admin-section.subjects.index to subjects.index
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully!');
    }

    /**
     * Remove a teacher from a subject
     */
    public function removeTeacher(Subject $subject, Teacher $teacher)
    {
        $subject->teachers()->detach($teacher->id);
        return back()->with('success', 'Teacher removed from subject successfully.');
    }
}
