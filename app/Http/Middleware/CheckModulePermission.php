<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Check Module Permission Middleware
 * 
 * Verifies that a user has permission to access a specific module.
 * - Super Admin: Can only access super-admin modules
 * - Business Owner: Can access all business modules
 * - Staff: Can only access granted modules
 */
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
            return redirect()->route('login')
                ->with('error', 'Please log in to access this page.');
        }

        $user = auth()->user();

        // Super Admin should not access business modules
        if ($user->isSuperAdmin()) {
            // Allow super-admin specific modules only
            $superAdminModules = [
                'super-admin-dashboard',
                'businesses',
                'system-users',
                'system-settings',
                'system-reports',
            ];
            
            if (!in_array($module, $superAdminModules)) {
                abort(403, 'Super Admin cannot access business modules. Please use the Super Admin dashboard.');
            }
        }

        // Check if user has permission to access the module
        if (!$user->hasModuleAccess($module)) {
            abort(403, 'You do not have permission to access this module.');
        }

        return $next($request);
    }
}
