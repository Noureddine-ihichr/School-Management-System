<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        $user = \App\Models\User::find(session('user_id'));

        if (!$user || $user->role !== 'admin') {
            return redirect('/login');
        }

        return $next($request);
    }
}
