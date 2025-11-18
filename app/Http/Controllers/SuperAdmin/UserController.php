<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Business;
use Illuminate\Http\Request;

/**
 * Super Admin User Management Controller
 * 
 * Manages users across all businesses in the system
 */
class UserController extends Controller
{
    /**
     * Display a listing of all users
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = User::withoutGlobalScope('business')
            ->with('business')
            ->where('role', '!=', 'super_admin');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by business
        if ($request->filled('business_id')) {
            $query->where('business_id', $request->business_id);
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $users = $query->paginate(20);

        // Get all businesses for filter dropdown
        $businesses = Business::withoutGlobalScope('business')
            ->orderBy('name')
            ->get();

        return view('super-admin.users.index', compact('users', 'businesses'));
    }

    /**
     * Display the specified user
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        // Load user without tenant scope
        $user = User::withoutGlobalScope('business')
            ->with('business')
            ->findOrFail($user->id);

        // Prevent viewing Super Admin users
        if ($user->isSuperAdmin()) {
            abort(403, 'Cannot view Super Admin users.');
        }

        // Get user statistics (if applicable)
        $stats = [];
        
        if ($user->role === 'staff') {
            // Get staff-specific stats if needed
            $stats['allowed_modules'] = $user->getAllowedModules();
        }

        return view('super-admin.users.show', compact('user', 'stats'));
    }

    /**
     * Toggle user active status
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(User $user)
    {
        // Load user without tenant scope
        $user = User::withoutGlobalScope('business')
            ->findOrFail($user->id);

        // Prevent modifying Super Admin users
        if ($user->isSuperAdmin()) {
            abort(403, 'Cannot modify Super Admin users.');
        }

        try {
            $user->update([
                'is_active' => !$user->is_active
            ]);

            $status = $user->is_active ? 'activated' : 'deactivated';

            return back()->with('success', "User {$status} successfully!");

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update user status: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Load user without tenant scope
        $user = User::withoutGlobalScope('business')
            ->findOrFail($user->id);

        // Prevent deleting Super Admin users
        if ($user->isSuperAdmin()) {
            abort(403, 'Cannot delete Super Admin users.');
        }

        // Prevent deleting Business Owners
        if ($user->isBusinessOwner()) {
            return back()->with('error', 'Cannot delete Business Owner. Please delete the business instead.');
        }

        try {
            $user->delete();

            return redirect()
                ->route('super-admin.users.index')
                ->with('success', 'User deleted successfully!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}

