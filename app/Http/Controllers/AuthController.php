<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
{
    // Validate the request
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Find the user by email
    $user = \App\Models\User::where('email', $request->email)->first();

    if ($user && \Hash::check($request->password, $user->password)) {
        // Store user ID in the session
        session(['user_id' => $user->id]);

        // Redirect based on the user's role
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        // (Add other roles later, e.g., teacher, student)
        else {
            return redirect('/'); // Temporary for now
        }
    }

    // If authentication fails, redirect back with an error
    return back()->withErrors(['login' => 'Invalid email or password']);
}

    public function logout()
    {
        session()->forget('user_id');
        return redirect('/login');
    }

}
