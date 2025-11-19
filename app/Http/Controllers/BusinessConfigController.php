<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\SalesChannel;
use App\Models\ExpenseCategory;
use App\Models\BusinessSetting;
use Illuminate\Http\Request;

class BusinessConfigController extends Controller
{
    /**
     * Display business configuration page
     */
    public function index()
    {
        $business = auth()->user()->business;
        
        // Load categories
        $productCategories = ProductCategory::where('business_id', $business->id)->get();
        $salesChannels = SalesChannel::where('business_id', $business->id)->get();
        $expenseCategories = ExpenseCategory::where('business_id', $business->id)->get();
        
        // Load business settings
        $productTypes = BusinessSetting::where('business_id', $business->id)
            ->where('setting_key', 'product_type')->ordered()->get();
        $units = BusinessSetting::where('business_id', $business->id)
            ->where('setting_key', 'unit_of_measurement')->ordered()->get();
        $paymentMethods = BusinessSetting::where('business_id', $business->id)
            ->where('setting_key', 'payment_method')->ordered()->get();
        $paymentStatuses = BusinessSetting::where('business_id', $business->id)
            ->where('setting_key', 'payment_status')->ordered()->get();
        $expenseStatuses = BusinessSetting::where('business_id', $business->id)
            ->where('setting_key', 'expense_status')->ordered()->get();
        
        return view('settings.business-config', compact(
            'business',
            'productCategories', 'salesChannels', 'expenseCategories',
            'productTypes', 'units', 'paymentMethods', 'paymentStatuses', 'expenseStatuses'
        ));
    }

    // ==================== Product Categories ====================
    public function storeProductCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $validated['business_id'] = auth()->user()->business_id;
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        ProductCategory::create($validated);
        
        return response()->json(['success' => true, 'message' => 'Category added successfully']);
    }

    public function updateProductCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        $category = ProductCategory::where('business_id', auth()->user()->business_id)->findOrFail($id);
        $category->update($validated);
        
        return response()->json(['success' => true, 'message' => 'Category updated successfully']);
    }

    public function destroyProductCategory($id)
    {
        $category = ProductCategory::where('business_id', auth()->user()->business_id)->findOrFail($id);
        $category->delete();
        
        return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
    }

    // ==================== Sales Channels ====================
    public function storeSalesChannel(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $validated['business_id'] = auth()->user()->business_id;
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        SalesChannel::create($validated);
        
        return response()->json(['success' => true, 'message' => 'Sales channel added successfully']);
    }

    public function updateSalesChannel(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        $channel = SalesChannel::where('business_id', auth()->user()->business_id)->findOrFail($id);
        $channel->update($validated);
        
        return response()->json(['success' => true, 'message' => 'Sales channel updated successfully']);
    }

    public function destroySalesChannel($id)
    {
        $channel = SalesChannel::where('business_id', auth()->user()->business_id)->findOrFail($id);
        $channel->delete();
        
        return response()->json(['success' => true, 'message' => 'Sales channel deleted successfully']);
    }

    // ==================== Expense Categories ====================
    public function storeExpenseCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $validated['business_id'] = auth()->user()->business_id;
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        ExpenseCategory::create($validated);
        
        return response()->json(['success' => true, 'message' => 'Expense category added successfully']);
    }

    public function updateExpenseCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        $category = ExpenseCategory::where('business_id', auth()->user()->business_id)->findOrFail($id);
        $category->update($validated);
        
        return response()->json(['success' => true, 'message' => 'Expense category updated successfully']);
    }

    public function destroyExpenseCategory($id)
    {
        $category = ExpenseCategory::where('business_id', auth()->user()->business_id)->findOrFail($id);
        $category->delete();
        
        return response()->json(['success' => true, 'message' => 'Expense category deleted successfully']);
    }

    // ==================== Business Settings (Generic) ====================
    public function storeSetting(Request $request)
    {
        $validated = $request->validate([
            'setting_key' => 'required|string',
            'setting_value' => 'required|string',
            'setting_label' => 'required|string',
            'description' => 'nullable|string',
        ]);
        
        $validated['business_id'] = auth()->user()->business_id;
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        BusinessSetting::create($validated);
        
        return response()->json(['success' => true, 'message' => 'Setting added successfully']);
    }

    public function updateSetting(Request $request, $id)
    {
        $validated = $request->validate([
            'setting_label' => 'required|string',
            'setting_value' => 'required|string',
            'description' => 'nullable|string',
        ]);
        
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        $setting = BusinessSetting::where('business_id', auth()->user()->business_id)->findOrFail($id);
        
        if ($setting->is_system) {
            return response()->json(['success' => false, 'message' => 'Cannot edit system settings'], 403);
        }
        
        $setting->update($validated);
        
        return response()->json(['success' => true, 'message' => 'Setting updated successfully']);
    }

    public function destroySetting($id)
    {
        $setting = BusinessSetting::where('business_id', auth()->user()->business_id)->findOrFail($id);
        
        if ($setting->is_system) {
            return response()->json(['success' => false, 'message' => 'Cannot delete system settings'], 403);
        }
        
        $setting->delete();
        
        return response()->json(['success' => true, 'message' => 'Setting deleted successfully']);
    }
}

