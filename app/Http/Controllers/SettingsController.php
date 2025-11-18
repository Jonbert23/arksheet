<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function company()
    {
        return view('settings/company');
    }
    
    public function currencies()
    {
        return view('settings/currencies');
    }
    
    public function language()
    {
        return view('settings/language');
    }
    
    public function notification()
    {
        return view('settings/notification');
    }
    
    public function notificationAlert()
    {
        return view('settings/notificationAlert');
    }
    
    public function paymentGateway()
    {
        return view('settings/paymentGateway');
    }
    
    public function theme()
    {
        return view('settings/theme');
    }
    
    /**
     * Display business settings form
     */
    public function business()
    {
        // Get the current user's business
        $business = auth()->user()->business;
        
        // If no business exists, create a default one
        if (!$business) {
            $business = new Business([
                'name' => '',
                'email' => '',
                'currency' => 'USD',
                'timezone' => 'America/New_York',
                'is_active' => true,
            ]);
        }
        
        return view('settings.business', compact('business'));
    }
    
    /**
     * Update business settings
     */
    public function updateBusiness(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'founder' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'business_type' => 'nullable|string|max:100',
            'employees' => 'nullable|string|max:50',
            'years_in_business' => 'nullable|string|max:50',
            'date_founded' => 'nullable|date',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|max:100',
            'business_hours' => 'nullable|string|max:255',
            'currency' => 'required|string|max:10',
            'timezone' => 'required|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);
        
        // Handle the is_active checkbox
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        // Get the current user's business
        $business = auth()->user()->business;
        
        // If no business exists, create one
        if (!$business) {
            $business = new Business();
            $business->save();
            
            // Associate business with current user
            auth()->user()->business_id = $business->id;
            auth()->user()->save();
        }
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($business->logo && Storage::disk('public')->exists($business->logo)) {
                Storage::disk('public')->delete($business->logo);
            }
            
            // Store new logo
            $logoPath = $request->file('logo')->store('business-logos', 'public');
            $validated['logo'] = $logoPath;
        }
        
        // Update business information
        $business->update($validated);
        
        return redirect()
            ->route('settings.business')
            ->with('success', 'Business settings updated successfully!');
    }
    
}
