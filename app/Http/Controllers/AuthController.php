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
            auth()->login($user); // Laravel's built-in auth system
            
            // Redirect based on the user's role
            if ($user->role === 'super_admin') {
                // Redirect super admin to the admin dashboard
                return redirect()->route('dashboard.admin');
            }
    
            if ($user->role === 'admin') {
                // Redirect regular admin to the admin dashboard
                return redirect()->route('dashboard.admin');
            }
    
            if ($user->role === 'student') {
                // Redirect students to their dashboard
                return redirect()->route('dashboard.student');
            }
    
            // (Add other roles later, e.g., teacher)
            return redirect('/'); // Temporary fallback
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
