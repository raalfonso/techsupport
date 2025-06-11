<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            // User is not logged in OR is not an admin
            // Redirect them or abort with a 403 Forbidden error
            return redirect('/dashboard')->with('error', 'You do not have admin access.');
            // OR:
            // abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}