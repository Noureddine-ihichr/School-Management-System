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
    ]);

    // Create the new admin
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Hash the password
        'role' => 'admin', 
    ]);

    // Redirect back to the list of admins (we'll create this later)
    return redirect()->route('admins.create')->with('success', 'Admin created successfully!');
}

}
