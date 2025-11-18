<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Business extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'founder',
        'category',
        'date_founded',
        'logo',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'phone',
        'email',
        'website',
        'currency',
        'timezone',
        'tax_id',
        'business_type',
        'business_hours',
        'employees',
        'years_in_business',
        'settings',
        'is_active',
    ];

    protected $casts = [
        'date_founded' => 'date',
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();
        
        // Auto-generate unique slug from name
        static::creating(function ($business) {
            if (empty($business->slug)) {
                $slug = Str::slug($business->name);
                $originalSlug = $slug;
                $count = 1;
                
                // Check if slug exists and make it unique
                while (static::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
                
                $business->slug = $slug;
            }
        });
    }

    /**
     * Relationships
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function salesChannels()
    {
        return $this->hasMany(SalesChannel::class);
    }

    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }

    public function targetGoals()
    {
        return $this->hasMany(TargetGoal::class);
    }

    /**
     * Helper Methods
     */
    public function getSetting($key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }

    public function setSetting($key, $value)
    {
        $settings = $this->settings ?? [];
        data_set($settings, $key, $value);
        $this->settings = $settings;
        $this->save();
    }
}
