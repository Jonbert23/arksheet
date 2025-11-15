<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Goal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'business_id',
        'user_id',
        'name',
        'description',
        'goal_type',
        'target_amount',
        'current_amount',
        'start_date',
        'end_date',
        'priority',
        'status',
        'product_id',
        'product_category_id',
        'sales_channel_id',
        'progress_percentage',
        'completed_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'progress_percentage' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function salesChannel()
    {
        return $this->belongsTo(SalesChannel::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeCurrent($query)
    {
        return $query->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Helper Methods
     */
    public function updateProgress()
    {
        $currentAmount = $this->calculateCurrentAmount();
        $this->current_amount = $currentAmount;
        $this->progress_percentage = $this->target_amount > 0 
            ? min(($currentAmount / $this->target_amount) * 100, 100) 
            : 0;

        // Auto-complete if target reached
        if ($this->progress_percentage >= 100 && $this->status !== 'completed') {
            $this->status = 'completed';
            $this->completed_at = now();
        }

        $this->save();
    }

    public function calculateCurrentAmount()
    {
        $dateFrom = $this->start_date->format('Y-m-d');
        $dateTo = min($this->end_date, now())->format('Y-m-d');

        switch ($this->goal_type) {
            case 'sales_revenue':
                return $this->calculateSalesRevenue($dateFrom, $dateTo);
            
            case 'sales_volume':
                return $this->calculateSalesVolume($dateFrom, $dateTo);
            
            case 'product_sales':
                return $this->calculateProductSales($dateFrom, $dateTo);
            
            case 'customer_acquisition':
                return $this->calculateCustomerAcquisition($dateFrom, $dateTo);
            
            case 'expense_reduction':
                return $this->calculateExpenseReduction($dateFrom, $dateTo);
            
            case 'profit_margin':
                return $this->calculateProfitMargin($dateFrom, $dateTo);
            
            default:
                return $this->current_amount;
        }
    }

    private function calculateSalesRevenue($dateFrom, $dateTo)
    {
        $query = Sale::where('business_id', $this->business_id)
            ->whereBetween('date', [$dateFrom, $dateTo]);

        if ($this->sales_channel_id) {
            $query->where('sales_channel_id', $this->sales_channel_id);
        }

        return $query->sum('total');
    }

    private function calculateSalesVolume($dateFrom, $dateTo)
    {
        $query = Sale::where('business_id', $this->business_id)
            ->whereBetween('date', [$dateFrom, $dateTo]);

        if ($this->sales_channel_id) {
            $query->where('sales_channel_id', $this->sales_channel_id);
        }

        return $query->count();
    }

    private function calculateProductSales($dateFrom, $dateTo)
    {
        $query = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.business_id', $this->business_id)
            ->whereBetween('sales.date', [$dateFrom, $dateTo]);

        if ($this->product_id) {
            $query->where('sale_items.product_id', $this->product_id);
            return $query->sum('sale_items.total');
        } elseif ($this->product_category_id) {
            $query->join('products', 'sale_items.product_id', '=', 'products.id')
                  ->where('products.product_category_id', $this->product_category_id);
            return $query->sum('sale_items.total');
        }

        return 0;
    }

    private function calculateCustomerAcquisition($dateFrom, $dateTo)
    {
        return Customer::where('business_id', $this->business_id)
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();
    }

    private function calculateExpenseReduction($dateFrom, $dateTo)
    {
        // Calculate expense reduction compared to previous period
        $currentPeriodExpenses = Expense::where('business_id', $this->business_id)
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->sum('amount');

        $previousPeriodStart = Carbon::parse($dateFrom)->subDays(Carbon::parse($dateFrom)->diffInDays($dateTo) + 1);
        $previousPeriodEnd = Carbon::parse($dateFrom)->subDay();

        $previousPeriodExpenses = Expense::where('business_id', $this->business_id)
            ->whereBetween('date', [$previousPeriodStart, $previousPeriodEnd])
            ->sum('amount');

        // Return the amount saved
        return max($previousPeriodExpenses - $currentPeriodExpenses, 0);
    }

    private function calculateProfitMargin($dateFrom, $dateTo)
    {
        $sales = Sale::where('business_id', $this->business_id)
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->get();

        $revenue = $sales->sum('subtotal');
        $cogs = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.business_id', $this->business_id)
            ->whereBetween('sales.date', [$dateFrom, $dateTo])
            ->sum('sale_items.cost');

        $grossProfit = $revenue - $cogs;
        return $revenue > 0 ? ($grossProfit / $revenue) * 100 : 0;
    }

    /**
     * Status helpers
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }

    public function isOnTrack()
    {
        $totalDays = $this->start_date->diffInDays($this->end_date);
        $daysElapsed = $this->start_date->diffInDays(now());
        $expectedProgress = $totalDays > 0 ? ($daysElapsed / $totalDays) * 100 : 0;

        return $this->progress_percentage >= $expectedProgress * 0.9; // 90% of expected
    }

    public function getDaysRemaining()
    {
        return (int) max(now()->diffInDays($this->end_date, false), 0);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'active' => $this->isOnTrack() ? 'success' : 'warning',
            'completed' => 'success',
            'failed' => 'danger',
            'paused' => 'secondary',
            default => 'secondary',
        };
    }

    public function getGoalTypeLabel()
    {
        return match($this->goal_type) {
            'sales_revenue' => 'Sales Revenue',
            'sales_volume' => 'Sales Volume',
            'product_sales' => 'Product Sales',
            'customer_acquisition' => 'Customer Acquisition',
            'expense_reduction' => 'Expense Reduction',
            'profit_margin' => 'Profit Margin',
            'custom' => 'Custom Goal',
            default => 'Unknown',
        };
    }

    public function getPriorityLabel()
    {
        return match($this->priority) {
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            default => 'Unknown',
        };
    }
}
