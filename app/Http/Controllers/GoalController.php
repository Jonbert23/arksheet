<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SalesChannel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    /**
     * Display a listing of goals with progress tracking dashboard
     */
    public function index(Request $request)
    {
        $business = Auth::user()->business;
        
        $filter = $request->input('filter', 'all');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        
        $query = Goal::where('business_id', $business->id)
            ->with(['user', 'product', 'productCategory', 'salesChannel'])
            ->latest('created_at');

        // Apply status filters
        switch ($filter) {
            case 'active':
                $query->active()->current();
                break;
            case 'upcoming':
                $query->active()->upcoming();
                break;
            case 'completed':
                $query->completed();
                break;
            case 'all':
                // No filter - show all goals
                break;
    }

        // Apply date range filter
        if ($dateFrom && $dateTo) {
            $query->where(function($q) use ($dateFrom, $dateTo) {
                // Include goals that overlap with the selected date range
                $q->where(function($subQ) use ($dateFrom, $dateTo) {
                    $subQ->whereBetween('start_date', [$dateFrom, $dateTo])
                         ->orWhereBetween('end_date', [$dateFrom, $dateTo])
                         ->orWhere(function($dateQ) use ($dateFrom, $dateTo) {
                             $dateQ->where('start_date', '<=', $dateFrom)
                                   ->where('end_date', '>=', $dateTo);
                         });
                });
            });
        }

        $goals = $query->get();

        // Update progress for all active goals
        foreach ($goals->where('status', 'active') as $goal) {
            $goal->updateProgress();
        }

        // Calculate summary statistics based on filters
        // Create base query for metrics with date filter applied
        $metricsQuery = Goal::where('business_id', $business->id);
        
        // Apply date range filter to metrics
        if ($dateFrom && $dateTo) {
            $metricsQuery->where(function($q) use ($dateFrom, $dateTo) {
                $q->where(function($subQ) use ($dateFrom, $dateTo) {
                    $subQ->whereBetween('start_date', [$dateFrom, $dateTo])
                         ->orWhereBetween('end_date', [$dateFrom, $dateTo])
                         ->orWhere(function($dateQ) use ($dateFrom, $dateTo) {
                             $dateQ->where('start_date', '<=', $dateFrom)
                                   ->where('end_date', '>=', $dateTo);
                         });
                });
            });
        }
        
        // Calculate metrics from filtered goals (date range only, not status filter)
        $activeGoals = (clone $metricsQuery)->active()->current()->count();
        $completedGoals = (clone $metricsQuery)->completed()->count();
        
        // Get all active goals for on-track/at-risk calculation
        $allActiveGoals = (clone $metricsQuery)->active()->get();
        foreach ($allActiveGoals as $goal) {
            $goal->updateProgress();
        }
        $onTrackGoals = $allActiveGoals->filter(fn($g) => $g->isOnTrack())->count();
        $atRiskGoals = $allActiveGoals->filter(fn($g) => !$g->isOnTrack())->count();

        return view('goals.index', compact('goals', 'filter', 'activeGoals', 'completedGoals', 'onTrackGoals', 'atRiskGoals'));
    }

    /**
     * Show the form for creating a new goal
     */
    public function create(Request $request)
    {
        $business = Auth::user()->business;
        
        $products = Product::where('business_id', $business->id)->orderBy('name')->get();
        $categories = ProductCategory::where('business_id', $business->id)->orderBy('name')->get();
        $channels = SalesChannel::where('business_id', $business->id)->orderBy('name')->get();

        // If AJAX request, return only the form partial
        if ($request->ajax()) {
            return view('goals.partials.create-form', compact('products', 'categories', 'channels'));
        }

        return view('goals.create', compact('products', 'categories', 'channels'));
    }

    /**
     * Store a newly created goal
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_type' => 'required|in:sales_revenue,sales_volume,product_sales,customer_acquisition,expense_reduction,profit_margin,custom',
            'target_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'priority' => 'required|in:low,medium,high',
            'product_id' => 'nullable|exists:products,id',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'sales_channel_id' => 'nullable|exists:sales_channels,id',
        ]);

        $validated['business_id'] = Auth::user()->business->id;
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'active';

        $goal = Goal::create($validated);
        
        // Calculate initial progress
        $goal->updateProgress();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Goal created successfully!',
                'goal' => $goal
            ]);
        }

        return redirect()->route('goals.index')
            ->with('success', 'Goal created successfully!');
    }

    /**
     * Display the specified goal
     */
    public function show(Goal $goal)
    {
        $this->authorizeGoal($goal);
        
        $goal->load(['user', 'product', 'productCategory', 'salesChannel']);
        $goal->updateProgress();

        return view('goals.show', compact('goal'));
    }

    /**
     * Show the form for editing the specified goal
     */
    public function edit(Request $request, Goal $goal)
    {
        $this->authorizeGoal($goal);
        
        $business = Auth::user()->business;
        
        $products = Product::where('business_id', $business->id)->orderBy('name')->get();
        $categories = ProductCategory::where('business_id', $business->id)->orderBy('name')->get();
        $channels = SalesChannel::where('business_id', $business->id)->orderBy('name')->get();

        // If AJAX request, return only the form partial
        if ($request->ajax()) {
            return view('goals.partials.edit-form', compact('goal', 'products', 'categories', 'channels'));
        }

        return view('goals.edit', compact('goal', 'products', 'categories', 'channels'));
    }

    /**
     * Update the specified goal
     */
    public function update(Request $request, Goal $goal)
    {
        $this->authorizeGoal($goal);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'goal_type' => 'required|in:sales_revenue,sales_volume,product_sales,customer_acquisition,expense_reduction,profit_margin,custom',
            'target_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:active,paused,completed,failed',
            'product_id' => 'nullable|exists:products,id',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'sales_channel_id' => 'nullable|exists:sales_channels,id',
        ]);

        $goal->update($validated);
        $goal->updateProgress();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Goal updated successfully!',
                'goal' => $goal
            ]);
        }

        return redirect()->route('goals.index')
            ->with('success', 'Goal updated successfully!');
    }

    /**
     * Remove the specified goal
     */
    public function destroy(Goal $goal)
    {
        $this->authorizeGoal($goal);

        $goal->delete();

        return redirect()->route('goals.index')
            ->with('success', 'Goal deleted successfully!');
    }

    /**
     * Update progress for a specific goal (AJAX)
     */
    public function updateProgress(Goal $goal)
    {
        $this->authorizeGoal($goal);
        
        $goal->updateProgress();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'goal' => $goal->fresh(),
            ]);
        }

        return redirect()->back()->with('success', 'Goal progress updated!');
    }

    /**
     * Refresh all goals progress (AJAX)
     */
    public function refreshAll()
    {
        $business = Auth::user()->business;
        
        $goals = Goal::where('business_id', $business->id)->active()->get();
        
        foreach ($goals as $goal) {
            $goal->updateProgress();
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'All goals updated successfully',
            ]);
        }

        return redirect()->back()->with('success', 'All goals updated successfully!');
    }

    /**
     * Authorize access to goal
     */
    private function authorizeGoal(Goal $goal)
    {
        if ($goal->business_id !== Auth::user()->business->id) {
            abort(403, 'Unauthorized access to this goal.');
        }
    }
}
