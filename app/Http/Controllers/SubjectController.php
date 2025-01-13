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
        return view('subjects.index', compact('subjects'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::all();
        return view('subjects.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|unique:subjects,name|max:255',
            'code' => 'nullable|unique:subjects,code|max:50',
            'description' => 'nullable|string',
            'teachers' => 'nullable|array',
            'teachers.*' => 'exists:teachers,id'
        ]);
    
        // Create the subject
        $subject = Subject::create([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'description' => $validated['description']
        ]);

        // Attach teachers if any are selected
        if ($request->has('teachers')) {
            $subject->teachers()->attach($request->teachers);
        }
    
        // Redirect to the index page with a success message
        return redirect()->route('subjects.index')->with('success', 'Subject created successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Retrieve the subject by its ID with teachers relationship
        $subject = Subject::with('teachers')->findOrFail($id);
    
        // Pass the subject data to the view
        return view('subjects.show', compact('subject'));
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
        return view('subjects.edit', compact('subject', 'teachers'));
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
    
        // Redirect to the subject list with a success message
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

    // Redirect to the index page with a success message
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
