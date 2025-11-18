<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait TenantScope
{
    /**
     * Boot the tenant scope trait for a model.
     * 
     * This trait automatically scopes queries to the current user's business
     * and assigns business_id when creating new records.
     * 
     * Super Admin users are exempt from tenant scoping and can access all businesses.
     */
    protected static function bootTenantScope()
    {
        // Automatically add business_id when creating a new record
        static::creating(function (Model $model) {
            // Skip auto-assignment for Super Admin
            if (auth()->check() && auth()->user()->isSuperAdmin()) {
                return;
            }
            
            // Auto-assign business_id for Business Owner and Staff
            if (auth()->check() && auth()->user()->business_id) {
                $model->business_id = auth()->user()->business_id;
            }
        });

        // Automatically scope all queries to current business
        static::addGlobalScope('business', function (Builder $builder) {
            // Skip tenant scope for Super Admin
            if (auth()->check() && auth()->user()->isSuperAdmin()) {
                return;
            }
            
            // Apply tenant scope for Business Owner and Staff
            if (auth()->check() && auth()->user()->business_id) {
                $builder->where($builder->getQuery()->from . '.business_id', auth()->user()->business_id);
            }
        });
    }

    /**
     * Get query without tenant scope
     * 
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithoutTenant(Builder $query)
    {
        return $query->withoutGlobalScope('business');
    }

    /**
     * Get query for specific business
     * 
     * @param Builder $query
     * @param int $businessId
     * @return Builder
     */
    public function scopeForBusiness(Builder $query, $businessId)
    {
        return $query->withoutGlobalScope('business')->where('business_id', $businessId);
    }
}

