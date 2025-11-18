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
    
    /**
     * Check if user is Super Admin
     * 
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is Business Owner
     * 
     * @return bool
     */
    public function isBusinessOwner(): bool
    {
        return $this->role === 'business_owner';
    }

    /**
     * Check if user is Admin (backward compatibility)
     * Calls isBusinessOwner() internally
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isBusinessOwner();
    }

    /**
     * Check if user is Manager
     * 
     * @return bool
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Check if user is Accountant
     * 
     * @return bool
     */
    public function isAccountant(): bool
    {
        return $this->role === 'accountant';
    }

    /**
     * Check if user is Staff
     * 
     * @return bool
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Check if user has specific role(s)
     * 
     * @param string|array $role
     * @return bool
     */
    public function hasRole($role): bool
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }

    /**
     * Check if user can access a specific business
     * Super Admin can access all businesses
     * Business Owner and Staff can only access their own business
     * 
     * @param int $businessId
     * @return bool
     */
    public function canAccessBusiness(int $businessId): bool
    {
        // Super Admin can access all businesses
        if ($this->isSuperAdmin()) {
            return true;
        }
        
        // Business Owner and Staff can only access their own business
        return $this->business_id == $businessId;
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
    
    /**
     * Check if user has access to a specific module
     * 
     * @param string $module
     * @return bool
     */
    public function hasModuleAccess(string $module): bool
    {
        // Super Admin has access to super-admin specific modules
        if ($this->isSuperAdmin()) {
            $superAdminModules = [
                'super-admin-dashboard',
                'businesses',
                'system-users',
                'system-settings',
                'system-reports',
            ];
            return in_array($module, $superAdminModules);
        }

        // Business Owner has access to all business modules
        if ($this->isBusinessOwner()) {
            return true;
        }

        // Staff: Check if user has permission to the specific module
        return in_array($module, $this->permissions ?? []);
    }

    /**
     * Check if user has access to any of the specified modules
     * 
     * @param array $modules
     * @return bool
     */
    public function hasAnyModuleAccess(array $modules): bool
    {
        // Super Admin and Business Owner have access to all modules
        if ($this->isSuperAdmin() || $this->isBusinessOwner()) {
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

    /**
     * Get all modules the user has access to
     * 
     * @return array
     */
    public function getAllowedModules(): array
    {
        // Super Admin has access to super-admin modules
        if ($this->isSuperAdmin()) {
            return [
                'super-admin-dashboard' => 'Dashboard',
                'businesses' => 'Business Management',
                'system-users' => 'User Management',
                'system-settings' => 'System Settings',
                'system-reports' => 'System Reports',
            ];
        }

        // Business Owner has access to all business modules
        if ($this->isBusinessOwner()) {
            return $this->getAvailableModules();
        }

        // Staff: Return granted modules
        return $this->permissions ?? [];
    }

    /**
     * Get all available business modules
     * 
     * @return array
     */
    public static function getAvailableModules(): array
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
