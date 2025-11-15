<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\TenantScope;

class StockIn extends Model
{
    use HasFactory, SoftDeletes, TenantScope;

    protected $fillable = [
        'business_id',
        'product_id',
        'quantity',
        'cost_per_unit',
        'total_cost',
        'shipping_cost',
        'import_duties',
        'other_transaction_costs',
        'supplier',
        'date',
        'notes',
        'reference_number',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'cost_per_unit' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'import_duties' => 'decimal:2',
        'other_transaction_costs' => 'decimal:2',
        'date' => 'date',
    ];

    /**
     * Relationships
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor: Calculate Total Cost (if not set)
     */
    public function calculateTotalCost()
    {
        return $this->quantity * $this->cost_per_unit;
    }

    /**
     * Scopes
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('date', now()->month)
                     ->whereYear('date', now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('date', now()->year);
    }

    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeBySupplier($query, $supplier)
    {
        return $query->where('supplier', $supplier);
    }
}
