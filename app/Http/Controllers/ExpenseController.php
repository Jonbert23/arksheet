<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of expenses
     */
    public function index(Request $request)
    {
        $query = Expense::with('category');

        // Filter by category (exclude 'all')
        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $query->where('category_id', $request->category_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Get all expenses (DataTables handles pagination)
        $expenses = $query->latest('date')->get();
        $categories = ExpenseCategory::active()->orderBy('name')->get();

        return view('expenses.index', compact('expenses', 'categories'));
    }

    /**
     * Show the form for creating a new expense
     */
    public function create()
    {
        $categories = ExpenseCategory::active()->orderBy('name')->get();
        return view('expenses.create', compact('categories'));
    }

    /**
     * Store a newly created expense
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:255',
            'vendor' => 'nullable|string|max:255',
            'receipt' => 'nullable|string|max:255',
            'status' => 'required|in:fulfilled,unfulfilled',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            Expense::create(array_merge($validated, [
                'business_id' => auth()->user()->business_id,
            ]));

            DB::commit();

            // Check if AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Expense recorded successfully!'
                ]);
            }

            return redirect()->route('expenses.index')
                ->with('success', 'Expense recorded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to record expense: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to record expense: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified expense
     */
    public function show(Request $request, Expense $expense)
    {
        $expense->load('category');
        
        // Check if request expects JSON (AJAX request)
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'expense' => [
                    'id' => $expense->id,
                    'date' => $expense->date->format('Y-m-d'),
                    'date_formatted' => $expense->date->format('F d, Y'),
                    'category_id' => $expense->category_id,
                    'title' => $expense->title,
                    'description' => $expense->description,
                    'amount' => $expense->amount,
                    'payment_method' => $expense->payment_method,
                    'vendor' => $expense->vendor,
                    'receipt' => $expense->receipt,
                    'status' => $expense->status,
                    'category' => [
                        'id' => $expense->category->id,
                        'name' => $expense->category->name,
                    ],
                ],
                'currency' => auth()->user()->business->currency,
            ]);
        }
        
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified expense
     */
    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::active()->orderBy('name')->get();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified expense
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string|max:255',
            'vendor' => 'nullable|string|max:255',
            'receipt' => 'nullable|string|max:255',
            'status' => 'required|in:fulfilled,unfulfilled',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $expense->update($validated);

            DB::commit();

            // Check if AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Expense updated successfully!'
                ]);
            }

            return redirect()->route('expenses.index')
                ->with('success', 'Expense updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update expense: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to update expense: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified expense
     */
    public function destroy(Request $request, Expense $expense)
    {
        DB::beginTransaction();
        try {
            $expense->delete();

            DB::commit();

            // Check if AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Expense deleted successfully!'
                ]);
            }

            return redirect()->route('expenses.index')
                ->with('success', 'Expense deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete expense: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to delete expense: ' . $e->getMessage());
        }
    }
}

