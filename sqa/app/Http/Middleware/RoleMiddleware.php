<?php

// to prevent cross role access
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->role->name !== $role) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
