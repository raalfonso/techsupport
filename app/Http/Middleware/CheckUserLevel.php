<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AuthAssignment;

class CheckUserLevel
{
    /**
     * Handle an incoming request.
     *
     * Checks the user's assigned roles via auth_assignment → auth_item (RBAC).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Allowed role names from auth_item
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $userId = auth()->id();

        $hasRole = AuthAssignment::where('user_id', $userId)
            ->whereIn('item_name', $roles)
            ->exists();

        if (!$hasRole) {
            abort(403, 'Unauthorized. Access restricted.');
        }

        return $next($request);
    }
}
