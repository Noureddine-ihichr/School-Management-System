<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentAuth
{
    public function handle(Request $request, Closure $next)
    {
        $user = \App\Models\User::find(session('user_id'));

        if (!$user || $user->role !== 'student') {
            return redirect('/login');
        }

        return $next($request);
    }
}
