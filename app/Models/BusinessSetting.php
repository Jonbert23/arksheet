<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'setting_key',
        'setting_value',
        'setting_label',
        'description',
        'sort_order',
        'is_active',
        'is_system',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_system' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Relationship with Business
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Scope to filter by setting key
     */
    public function scopeForKey($query, $key)
    {
        return $query->where('setting_key', $key);
    }

    /**
     * Scope to filter active settings
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('setting_label');
    }
}

