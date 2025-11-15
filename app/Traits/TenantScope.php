<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait TenantScope
{
    protected static function bootTenantScope()
    {
        // Automatically add business_id when creating a new record
        static::creating(function (Model $model) {
            if (auth()->check() && auth()->user()->business_id) {
                $model->business_id = auth()->user()->business_id;
            }
        });

        // Automatically scope all queries to current business
        static::addGlobalScope('business', function (Builder $builder) {
            if (auth()->check() && auth()->user()->business_id) {
                $builder->where($builder->getQuery()->from . '.business_id', auth()->user()->business_id);
            }
        });
    }

    /**
     * Get query without tenant scope
     */
    public function scopeWithoutTenant(Builder $query)
    {
        return $query->withoutGlobalScope('business');
    }

    /**
     * Get query for specific business
     */
    public function scopeForBusiness(Builder $query, $businessId)
    {
        return $query->withoutGlobalScope('business')->where('business_id', $businessId);
    }
}

