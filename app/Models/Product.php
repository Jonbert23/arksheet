<?php

namespace App\Models;

use App\Traits\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, TenantScope;

    protected $fillable = [
        'business_id',
        'product_category_id',
        'name',
        'sku',
        'description',
        'additional_info',
        'type',
        'price',
        'cost',
        'tax_amount',
        'other_costs',
        'stock_quantity',
        'min_stock_alert',
        'unit',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'other_costs' => 'decimal:2',
        'stock_quantity' => 'integer',
        'min_stock_alert' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Helper Methods
     */
    public function isLowStock()
    {
        return $this->stock_quantity <= $this->min_stock_alert;
    }

    public function getStockStatus()
    {
        if ($this->stock_quantity == 0) {
            return 'out_of_stock';
        } elseif ($this->isLowStock()) {
            return 'low_stock';
        }
        return 'in_stock';
    }

    public function getStockStatusBadge()
    {
        $status = $this->getStockStatus();
        $badges = [
            'in_stock' => '<span class="badge bg-success">In Stock</span>',
            'low_stock' => '<span class="badge bg-warning">Low Stock</span>',
            'out_of_stock' => '<span class="badge bg-danger">Out of Stock</span>',
        ];
        return $badges[$status] ?? '';
    }

    /**
     * Calculate Total Costs (Item Cost + Tax + Other Costs)
     */
    public function getTotalCosts()
    {
        return $this->cost + $this->tax_amount + $this->other_costs;
    }

    /**
     * Calculate Estimated Profit (Selling Price - Total Costs)
     */
    public function getEstimatedProfit()
    {
        return $this->price - $this->getTotalCosts();
    }

    /**
     * Calculate Profit Margin ((Profit / Selling Price) * 100)
     */
    public function getProfitMargin()
    {
        if ($this->price == 0) {
            return 0;
        }
        return round(($this->getEstimatedProfit() / $this->price) * 100);
    }

    /**
     * Get all-time items sold count
     */
    public function getAllTimeItemsSold()
    {
        return $this->saleItems()->sum('quantity');
    }

    /**
     * Get all-time sales revenue (quantity * unit_price)
     */
    public function getAllTimeSales()
    {
        return $this->saleItems()->sum(\DB::raw('quantity * unit_price'));
    }

    /**
     * Scopes
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock_quantity', '<=', 'min_stock_alert');
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('stock_quantity', 0);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeProducts($query)
    {
        return $query->where('type', 'product');
    }

    public function scopeServices($query)
    {
        return $query->where('type', 'service');
    }
}
