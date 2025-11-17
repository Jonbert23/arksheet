# Quick Setup Guide - Business Configuration

## 🚀 Get Started in 3 Steps

### Step 1: Run Migration
```bash
cd C:\xampp\htdocs\arksheet
php artisan migrate
```

This creates the `business_settings` table.

### Step 2: Seed Default Settings (Optional)

Create and run this seeder to add default settings:

```bash
php artisan make:seeder BusinessSettingsSeeder
```

Then add this code to `database/seeders/BusinessSettingsSeeder.php`:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessSetting;
use App\Models\Business;

class BusinessSettingsSeeder extends Seeder
{
    public function run()
    {
        $business = Business::first();
        if (!$business) return;

        // Default Product Types
        $types = [
            ['key' => 'product_type', 'value' => 'product', 'label' => 'Physical Product', 'system' => true],
            ['key' => 'product_type', 'value' => 'service', 'label' => 'Service', 'system' => true],
        ];

        // Default Units
        $units = [
            ['key' => 'unit', 'value' => 'pcs', 'label' => 'Pieces', 'system' => true],
            ['key' => 'unit', 'value' => 'kg', 'label' => 'Kilograms', 'system' => true],
            ['key' => 'unit', 'value' => 'L', 'label' => 'Liters', 'system' => true],
        ];

        // Default Payment Methods
        $methods = [
            ['key' => 'payment_method', 'value' => 'cash', 'label' => 'Cash', 'system' => true],
            ['key' => 'payment_method', 'value' => 'card', 'label' => 'Credit/Debit Card', 'system' => true],
            ['key' => 'payment_method', 'value' => 'bank_transfer', 'label' => 'Bank Transfer', 'system' => true],
            ['key' => 'payment_method', 'value' => 'online', 'label' => 'Online Payment', 'system' => true],
        ];

        // Default Payment Statuses
        $statuses = [
            ['key' => 'payment_status', 'value' => 'pending', 'label' => 'Pending', 'system' => true],
            ['key' => 'payment_status', 'value' => 'partial', 'label' => 'Partially Paid', 'system' => true],
            ['key' => 'payment_status', 'value' => 'paid', 'label' => 'Paid', 'system' => true],
        ];

        // Default Expense Statuses
        $expenseStatuses = [
            ['key' => 'expense_status', 'value' => 'fulfilled', 'label' => 'Fulfilled', 'system' => true],
            ['key' => 'expense_status', 'value' => 'unfulfilled', 'label' => 'Unfulfilled', 'system' => true],
        ];

        $all = array_merge($types, $units, $methods, $statuses, $expenseStatuses);

        foreach ($all as $index => $item) {
            BusinessSetting::create([
                'business_id' => $business->id,
                'setting_key' => $item['key'],
                'setting_value' => $item['value'],
                'setting_label' => $item['label'],
                'sort_order' => $index,
                'is_active' => true,
                'is_system' => $item['system'],
            ]);
        }
    }
}
```

Run the seeder:
```bash
php artisan db:seed --class=BusinessSettingsSeeder
```

### Step 3: Access Configuration Page

1. Login as **Admin**
2. Navigate to **Settings → Configuration**
3. Start configuring!

---

## 📂 File Locations

If you need to customize:

- **Controller**: `app/Http/Controllers/BusinessConfigController.php`
- **Model**: `app/Models/BusinessSetting.php`
- **View**: `resources/views/settings/business-config.blade.php`
- **Partials**: `resources/views/settings/partials/*.blade.php`
- **Routes**: `routes/web.php` (search for "Business Configuration")

---

## 🎯 Quick Test

After setup, test by:

1. Go to Configuration page
2. Add a test product category
3. Go to Products → Add Product
4. Check if your new category appears in the dropdown

If it works, everything is set up correctly! ✅

---

## 🔗 Related Documentation

- `BUSINESS_CONFIGURATION_COMPLETE.md` - Full documentation
- `docs/BUSINESS_SETTINGS.md` - Business Settings docs

---

## 💬 Need Help?

- Check linter errors: View → Problems (in IDE)
- Clear cache: `php artisan cache:clear`
- Clear views: `php artisan view:clear`

Done! 🎉

