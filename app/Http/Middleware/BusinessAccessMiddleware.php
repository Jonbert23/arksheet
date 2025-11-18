<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Business Access Middleware
 * 
 * Verifies that a user has permission to access a specific business.
 * Super Admin can access any business.
 * Business Owner and Staff can only access their own business.
 */
class BusinessAccessMiddleware
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

        // Extract business_id from route parameters
        $businessId = $request->route('business');
        
        // If business_id is an object (model binding), get the ID
        if (is_object($businessId)) {
            $businessId = $businessId->id;
        }

        // Check if user can access this business
        if (!auth()->user()->canAccessBusiness($businessId)) {
            abort(403, 'Access denied. You do not have permission to access this business.');
        }

        return $next($request);
    }
}

