# Business Defaults Seeder Documentation

## Overview
This guide explains how to seed default product categories and business settings for the ArkSheets application.

---

## Default Data Included

### 1. Product Categories (10 Categories)
- ✅ Electronics
- ✅ Clothing & Apparel
- ✅ Food & Beverages
- ✅ Home & Garden
- ✅ Health & Beauty
- ✅ Sports & Outdoors
- ✅ Books & Media
- ✅ Toys & Games
- ✅ Office Supplies
- ✅ Automotive

### 2. Product Types (5 Types)
- ✅ Physical Product (System)
- ✅ Digital Product (System)
- ✅ Service (System)
- ✅ Subscription
- ✅ Bundle/Package

### 3. Units of Measurement (8 Units)
- ✅ Pieces (pcs) - System
- ✅ Kilogram (kg) - System
- ✅ Pounds (lbs)
- ✅ Liter (ltr)
- ✅ Gallon (gal)
- ✅ Meter (m)
- ✅ Box
- ✅ Pack

### 4. Payment Methods (6 Methods)
- ✅ Cash - System
- ✅ Bank Transfer - System
- ✅ Credit Card
- ✅ Debit Card
- ✅ Mobile Money
- ✅ Check

### 5. Payment Statuses (5 Statuses)
- ✅ Paid - System
- ✅ Pending - System
- ✅ Partial
- ✅ Overdue
- ✅ Cancelled

---

## How to Use

### Method 1: Using Artisan Command (Recommended)

**Seed all businesses:**
```bash
php artisan business:seed-defaults
```

**Seed specific business:**
```bash
php artisan business:seed-defaults --business_id=1
```

### Method 2: Using Database Seeder

**Seed with all demo data:**
```bash
php artisan db:seed
```

**Seed only product categories:**
```bash
php artisan db:seed --class=DefaultProductCategoriesSeeder
```

**Seed only business settings:**
```bash
php artisan db:seed --class=DefaultBusinessSettingsSeeder
```

### Method 3: From Fresh Installation

**Complete fresh setup:**
```bash
php artisan migrate:fresh --seed
```

This will:
1. Drop all tables
2. Run all migrations
3. Seed all demo data including defaults

---

## Important Notes

### System vs Custom Items

**System Items (`is_system = true`):**
- ✅ Cannot be deleted from the UI
- ✅ Core items required by the system
- ✅ Can be deactivated but not removed

**Custom Items (`is_system = false`):**
- ✅ Can be edited
- ✅ Can be deleted
- ✅ User-created or optional items

### FirstOrCreate Behavior

The seeders use `firstOrCreate()` which means:
- ✅ **Safe to run multiple times** - won't create duplicates
- ✅ Only creates if doesn't exist
- ✅ Perfect for adding new defaults in the future

---

## For Developers

### Adding New Default Categories

Edit `database/seeders/DefaultProductCategoriesSeeder.php`:

```php
$defaultCategories = [
    // ... existing categories ...
    [
        'name' => 'Your New Category',
        'description' => 'Category description',
        'is_active' => true,
    ],
];
```

### Adding New Product Types

Edit `database/seeders/DefaultProductCategoriesSeeder.php`:

```php
$defaultProductTypes = [
    // ... existing types ...
    [
        'setting_key' => 'product_type',
        'setting_value' => 'custom_type',
        'setting_label' => 'Custom Type',
        'description' => 'Your description',
        'sort_order' => 6,
        'is_active' => true,
        'is_system' => false, // Set to true if critical
    ],
];
```

### Adding New Units/Payment Methods/Statuses

Edit `database/seeders/DefaultBusinessSettingsSeeder.php`:

```php
$defaultUnits = [
    // Add your new unit here
];
```

---

## Verification

### Check What Was Seeded

**View Product Categories:**
```bash
# Via Tinker
php artisan tinker
>>> App\Models\ProductCategory::all()->pluck('name');
```

**View Product Types:**
```bash
php artisan tinker
>>> App\Models\BusinessSetting::where('setting_key', 'product_type')->get()->pluck('setting_label');
```

**Via UI:**
1. Log in as admin
2. Go to: **Business Settings** → **Configuration**
3. Check each tab:
   - Products → Product Categories
   - Products → Product Types
   - Stock → Units of Measurement
   - Sales → Payment Methods
   - Sales → Payment Status

---

## Troubleshooting

### No Businesses Found
**Error:** "No businesses found. Please create a business first."

**Solution:**
```bash
# Create a business first
php artisan db:seed --class=BusinessSeeder
# Then seed defaults
php artisan business:seed-defaults
```

### Duplicates Not Created
**Issue:** Running seeder multiple times doesn't create duplicates

**Reason:** This is **intended behavior**! The seeders use `firstOrCreate()` to prevent duplicates.

### Need to Reset Defaults
**Solution:**
```bash
# Option 1: Delete and reseed specific business
php artisan tinker
>>> App\Models\ProductCategory::where('business_id', 1)->delete();
>>> App\Models\BusinessSetting::where('business_id', 1)->delete();
>>> exit
php artisan business:seed-defaults --business_id=1

# Option 2: Fresh installation
php artisan migrate:fresh --seed
```

---

## Benefits

### For New Businesses
✅ Instant setup with common categories  
✅ No manual configuration needed  
✅ Ready to start adding products  
✅ Industry-standard options  

### For Developers
✅ Consistent data across installations  
✅ Easy to customize  
✅ Safe to run multiple times  
✅ No duplicate entries  

### For Users
✅ Pre-configured options  
✅ Can add custom categories  
✅ Can edit/deactivate defaults  
✅ Professional setup out-of-the-box  

---

## Quick Reference

| Command | Purpose |
|---------|---------|
| `php artisan business:seed-defaults` | Seed all businesses |
| `php artisan business:seed-defaults --business_id=1` | Seed specific business |
| `php artisan db:seed` | Full demo data + defaults |
| `php artisan db:seed --class=DefaultProductCategoriesSeeder` | Only categories |
| `php artisan db:seed --class=DefaultBusinessSettingsSeeder` | Only settings |
| `php artisan migrate:fresh --seed` | Fresh install with everything |

---

## Summary

The default business configuration seeders provide:
- ✅ **10 Product Categories** for common industries
- ✅ **5 Product Types** (physical, digital, service, subscription, bundle)
- ✅ **8 Units of Measurement** for inventory
- ✅ **6 Payment Methods** for transactions
- ✅ **5 Payment Statuses** for tracking

All defaults are:
- ✅ Safe to run multiple times
- ✅ Customizable via UI
- ✅ Marked as system or custom
- ✅ Active by default

**Created**: November 17, 2025  
**Version**: 1.0  
**Status**: ✅ Ready to Use

