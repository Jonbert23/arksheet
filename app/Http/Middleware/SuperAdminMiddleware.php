<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Super Admin Middleware
 * 
 * Protects routes that should only be accessible by Super Admin users.
 * Redirects unauthenticated users to login and returns 403 for non-Super Admin users.
 */
class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to access this page.');
        }

        // Check if user is Super Admin
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Access denied. Super Admin privileges required.');
        }

        return $next($request);
    }
}

