<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        if ($user->role !== $role && $user->role !== 'superadmin') {
            return redirect('/home')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}