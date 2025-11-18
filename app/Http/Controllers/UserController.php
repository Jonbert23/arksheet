<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::where('business_id', auth()->user()->business_id);

        // Date range filter
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        
        $query->whereBetween('created_at', [
            $dateFrom . ' 00:00:00',
            $dateTo . ' 23:59:59'
        ]);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('is_active')) {
            if ($request->is_active === '1' || $request->is_active === 'active') {
                $query->where('is_active', true);
            } else {
                $query->where('is_active', false);
            }
        }

        $users = $query->latest()->get();

        return view('users.index', compact('users', 'dateFrom', 'dateTo'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create(Request $request)
    {
        // Return JSON for AJAX requests (modal)
        if ($request->ajax() || $request->wantsJson()) {
            return view('users.partials.create-form');
        }

        return view('users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'role' => 'required|in:business_owner,manager,accountant,staff',
            'phone' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Default is_active to true if not provided
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = true;
        }

        // Handle permissions - business owners get all permissions automatically
        if ($validated['role'] === 'business_owner') {
            $validated['permissions'] = array_keys(\App\Models\User::getAvailableModules());
        } elseif (!isset($validated['permissions'])) {
            $validated['permissions'] = [];
        }

        DB::beginTransaction();
        try {
            User::create(array_merge($validated, [
                'business_id' => auth()->user()->business_id,
            ]));

            DB::commit();

            // Return JSON for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User created successfully!'
                ]);
            }

            return redirect()->route('users.index')
                ->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Return JSON for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create user: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to create user: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified user
     */
    public function show(Request $request, User $user)
    {
        // Check business scope
        if ($user->business_id !== auth()->user()->business_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Return JSON for AJAX requests (modal)
        if ($request->wantsJson() || $request->expectsJson() || $request->ajax()) {
            return response()->json([
                'user' => $user
            ]);
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(Request $request, User $user)
    {
        // Check business scope
        if ($user->business_id !== auth()->user()->business_id) {
            abort(403, 'Unauthorized action.');
        }

        // Return JSON for AJAX requests (modal)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'user' => $user
            ]);
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        // Check business scope
        if ($user->business_id !== auth()->user()->business_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'role' => 'required|in:business_owner,manager,accountant,staff',
            'phone' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ]);

        // Only hash password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle permissions - business owners get all permissions automatically
        if ($validated['role'] === 'business_owner') {
            $validated['permissions'] = array_keys(\App\Models\User::getAvailableModules());
        } elseif (!isset($validated['permissions'])) {
            $validated['permissions'] = [];
        }

        DB::beginTransaction();
        try {
            $user->update($validated);

            DB::commit();

            // Return JSON for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User updated successfully!'
                ]);
            }

            return redirect()->route('users.index')
                ->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Return JSON for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update user: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to update user: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Check business scope
        if ($user->business_id !== auth()->user()->business_id) {
            abort(403, 'Unauthorized action.');
        }

        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account!');
        }

        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();

            return redirect()->route('users.index')
                ->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}

