<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
{
    if (!auth()->check()) {
        // Guest → login
        return redirect()->route('login')->with('error', 'You must be logged in.');
    }

    $userRole = auth()->user()->role;

    if (!in_array($userRole, $roles)) {
        // Authenticated but not allowed → go to dashboard only if they can access it
        if (in_array($userRole, ['admin', 'company-owner'])) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
        }

        // Otherwise, logout or show 403
        auth()->logout();
        return redirect()->route('login')->with('error', 'Access denied.');
    }

    return $next($request);
}

}
