<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_id',
        'name',
        'email',
        'password',
        'role',
        'permissions',
        'phone',
        'avatar',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'permissions' => 'array',
        ];
    }

    /**
     * Relationships
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Role Helper Methods
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isAccountant()
    {
        return $this->role === 'accountant';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function hasRole($role)
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    public function hasPermission($permission)
    {
        // Admin has all permissions
        if ($this->isAdmin()) {
            return true;
        }

        // Define role permissions
        $permissions = [
            'manager' => ['view', 'create', 'edit', 'delete', 'manage_users'],
            'accountant' => ['view', 'create', 'edit', 'view_reports'],
            'staff' => ['view', 'create'],
        ];

        $rolePermissions = $permissions[$this->role] ?? [];
        return in_array($permission, $rolePermissions);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForBusiness($query, $businessId)
    {
        return $query->where('business_id', $businessId);
    }

    /**
     * Module Permission Methods
     */
    public function hasModuleAccess($module)
    {
        // Admin has access to all modules
        if ($this->isAdmin()) {
            return true;
        }

        // Check if user has permission to the specific module
        return in_array($module, $this->permissions ?? []);
    }

    public function hasAnyModuleAccess($modules)
    {
        // Admin has access to all modules
        if ($this->isAdmin()) {
            return true;
        }

        // Check if user has permission to any of the modules
        foreach ($modules as $module) {
            if ($this->hasModuleAccess($module)) {
                return true;
            }
        }

        return false;
    }

    public function getAllowedModules()
    {
        // Admin has access to all modules
        if ($this->isAdmin()) {
            return $this->getAvailableModules();
        }

        return $this->permissions ?? [];
    }

    public static function getAvailableModules()
    {
        return [
            'dashboard' => 'Dashboard',
            'products' => 'Products',
            'stock' => 'Stock Management',
            'sales' => 'Sales',
            'invoices' => 'Invoices',
            'customers' => 'Customers',
            'expenses' => 'Expenses',
            'reports' => 'Reports',
            'goals' => 'Target Goals',
            'users' => 'User Management',
        ];
    }
}
