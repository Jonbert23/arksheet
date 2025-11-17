<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            // Business Information
            'business_name' => ['required', 'string', 'max:255'],
            'business_category' => ['nullable', 'string', 'max:255'],
            'founder' => ['nullable', 'string', 'max:255'],
            'date_founded' => ['nullable', 'date'],
            
            // User Information
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        try {
            DB::beginTransaction();

            // Create Business
            $business = Business::create([
                'name' => $validated['business_name'],
                'category' => $validated['business_category'] ?? null,
                'founder' => $validated['founder'] ?? $validated['name'],
                'date_founded' => $validated['date_founded'] ?? now(),
                'is_active' => true,
            ]);

            // Create Admin User
            $user = User::create([
                'business_id' => $business->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'] ?? null,
                'role' => 'admin',
                'is_active' => true,
            ]);

            DB::commit();

            // Auto login
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Business registered successfully! Welcome to ArkSheets.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Registration failed. Please try again.');
        }
    }
}
