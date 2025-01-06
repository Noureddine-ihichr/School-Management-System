<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
   
    public function index()
    {
        // Fetch all admins (users with role = 'admin')
        $admins = User::where('role', 'admin')->get();
    
        // Return the admin management view
        return view('admin-management.index', compact('admins'));
    }


public function create()
{
    return view('admin-management.create');
}

public function store(Request $request)
{
    // Validate the input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed', // Requires password confirmation
        'profile_icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // Ensure it's an image

    ]);

    // Handle the profile icon upload
    $profileIconPath = null;
    if ($request->hasFile('profile_icon')) {
        $profileIconPath = $request->file('profile_icon')->store('profile_icons', 'public');
    }

    // Create the new admin
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Hash the password
        'role' => 'admin',
        'profile_icon' => $profileIconPath, // Save the path to the database

    ]);

    // Redirect back to the list of admins (we'll create this later)
    return redirect()->route('admin.management')->with('success', 'Admin created successfully!');
}

public function update(Request $request, $id)
{
    // Find the admin by ID
    $admin = User::findOrFail($id);

    // Validate the form input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $admin->id,
        'profile_icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
    ]);

    // Handle the profile icon upload if provided
    if ($request->hasFile('profile_icon')) {
        if ($admin->profile_icon) {
            // Delete the old icon
            \Storage::delete('public/' . $admin->profile_icon);
        }
        $admin->profile_icon = $request->file('profile_icon')->store('profile_icons', 'public');
    }

    // Update the admin details
    $admin->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // Redirect back with success message
    return redirect()->route('admin.management')->with('success', 'Admin updated successfully.');
}


public function edit($id)
{
    // Find the admin by ID
    $admin = User::findOrFail($id);

    // Pass the admin to the edit view
    return view('admin-management.edit', compact('admin'));
}

public function destroy($id)
{
    // Find the admin by ID
    $admin = User::findOrFail($id);

    // Check if the user is an admin
    if ($admin->role !== 'admin') {
        return redirect()->route('admin.management')->with('error', 'Cannot delete this user.');
    }

    // Delete the admin
    $admin->delete();

    return redirect()->route('admin.management')->with('success', 'Admin deleted successfully.');
}


}
