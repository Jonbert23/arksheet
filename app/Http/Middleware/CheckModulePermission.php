<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModulePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $module  The module name to check permission for
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has permission to access the module
        if (!auth()->user()->hasModuleAccess($module)) {
            abort(403, 'You do not have permission to access this module.');
        }

        return $next($request);
    }
}
