# Default Business Data Seeder

## 📋 Overview

The application now comes with **comprehensive default data** to help new users understand what types of data to configure and give them a head start. This eliminates the confusion of empty settings pages and provides practical examples.

---

## 🎯 What's Included

### **1. Product Types** (4 defaults)
Pre-configured product types to categorize your inventory:

| Value | Label | Description | System |
|-------|-------|-------------|--------|
| `product` | Physical Product | Tangible goods that can be shipped | ✅ |
| `digital` | Digital Product | Downloadable or online products | ❌ |
| `service` | Service | Intangible services provided to customers | ✅ |
| `subscription` | Subscription | Recurring subscription-based products | ❌ |

**System items** (✅) cannot be deleted by users.

---

### **2. Units of Measurement** (8 defaults)
Common units for inventory management:

| Value | Label | Description | System |
|-------|-------|-------------|--------|
| `pcs` | Pieces | Individual items or units | ✅ |
| `kg` | Kilogram | Weight measurement in kilograms | ✅ |
| `lbs` | Pounds | Weight measurement in pounds | ❌ |
| `ltr` | Liter | Volume measurement in liters | ❌ |
| `gal` | Gallon | Volume measurement in gallons | ❌ |
| `m` | Meter | Length measurement in meters | ❌ |
| `box` | Box | Items sold in boxes | ❌ |
| `pack` | Pack | Items sold in packs | ❌ |

---

### **3. Payment Methods** (13 defaults - Philippines-specific)
Popular payment options for Philippines businesses:

| Value | Label | Description | System |
|-------|-------|-------------|--------|
| `cash` | Cash | Cash payment | ✅ |
| `gcash` | GCash | GCash e-wallet payment | ❌ |
| `paymaya` | Maya (PayMaya) | Maya (formerly PayMaya) e-wallet | ❌ |
| `bank_transfer` | Bank Transfer | InstaPay, PESONet, or direct bank transfer | ❌ |
| `credit_card` | Credit Card | Visa, Mastercard, JCB | ❌ |
| `debit_card` | Debit Card | ATM/Debit card payment | ❌ |
| `shopeepay` | ShopeePay | ShopeePay e-wallet | ❌ |
| `grabpay` | GrabPay | GrabPay e-wallet | ❌ |
| `coins_ph` | Coins.ph | Coins.ph wallet | ❌ |
| `check` | Check | Payment by check | ❌ |
| `cod` | Cash on Delivery (COD) | Payment upon delivery | ❌ |
| `bayad_center` | Bayad Center | Payment via Bayad Center | ❌ |
| `711_cliqq` | 7-Eleven CLiQQ | Payment via 7-Eleven CLiQQ | ❌ |

---

### **4. Payment Statuses** (5 defaults)
Track payment status for invoices and sales:

| Value | Label | Description | System |
|-------|-------|-------------|--------|
| `paid` | Paid | Payment completed | ✅ |
| `pending` | Pending | Payment pending | ✅ |
| `partial` | Partial | Partially paid | ❌ |
| `overdue` | Overdue | Payment overdue | ❌ |
| `cancelled` | Cancelled | Payment cancelled | ❌ |

---

### **5. Expense Statuses** (4 defaults)
Manage expense approval workflow:

| Value | Label | Description | System |
|-------|-------|-------------|--------|
| `approved` | Approved | Expense has been approved | ✅ |
| `pending` | Pending | Awaiting approval | ✅ |
| `rejected` | Rejected | Expense has been rejected | ❌ |
| `reimbursed` | Reimbursed | Expense has been reimbursed | ❌ |

---

### **6. Product Categories** (10 defaults)
Common product categories for inventory organization:

- Electronics
- Clothing & Apparel
- Food & Beverages
- Home & Garden
- Health & Beauty
- Sports & Outdoors
- Books & Media
- Toys & Games
- Office Supplies
- Automotive

---

### **7. Expense Categories** (12 defaults)
Standard business expense categories:

- Office Supplies
- Utilities
- Rent & Lease
- Salaries & Wages
- Marketing & Advertising
- Travel & Transport
- Maintenance & Repairs
- Insurance
- Professional Services
- Training & Development
- Bank Charges & Fees
- Miscellaneous

---

### **8. Sales Channels** (7 defaults)
Common sales channels for multi-channel businesses:

- Physical Store
- 2nd Branch
- Online Store
- Shopify
- TikTok Shop
- Facebook Marketplace
- Instagram Shop

---

## 🚀 How to Use

### For New Installations

The default data is automatically seeded when you run:

```bash
php artisan db:seed
```

This will populate **ALL** default data for the business.

### For Existing Installations

If you already have a business setup and want to add default data:

```bash
# Seed all default data
php artisan db:seed --class=DefaultBusinessSettingsSeeder
php artisan db:seed --class=DefaultProductCategoriesSeeder
php artisan db:seed --class=ExpenseCategorySeeder
php artisan db:seed --class=SalesChannelSeeder
```

Or run specific seeders:

```bash
# Only business settings (types, units, payment methods, statuses)
php artisan db:seed --class=DefaultBusinessSettingsSeeder

# Only product categories
php artisan db:seed --class=DefaultProductCategoriesSeeder

# Only expense categories
php artisan db:seed --class=ExpenseCategorySeeder

# Only sales channels
php artisan db:seed --class=SalesChannelSeeder
```

---

## ✏️ Customization

### Users Can:
- ✅ Add new items
- ✅ Edit existing items (except system items)
- ✅ Delete custom items
- ✅ Activate/Deactivate items
- ✅ Reorder items (via `sort_order`)

### Users Cannot:
- ❌ Delete system items (marked as `is_system = true`)
- ❌ Modify core system values (though they can edit labels)

---

## 💡 Benefits

### 1. **Onboarding Made Easy**
New users immediately see examples of what to add, reducing confusion and setup time.

### 2. **Best Practices**
Default data follows industry standards and best practices.

### 3. **Instant Productivity**
Users can start adding products, sales, and expenses immediately without setting up configurations first.

### 4. **Flexibility**
All default data can be customized, extended, or removed (except system items) to match specific business needs.

### 5. **No Empty States**
Business settings pages are never empty, providing a better user experience.

---

## 📍 Where to Find Default Data

Users can view and manage default data in:

**Settings → Business Configuration**
- **Business Tab**: (General business info)
- **Products Tab**: Product Types, Product Categories
- **Stock Tab**: Units of Measurement
- **Sales Tab**: Sales Channels, Payment Methods, Payment Statuses
- **Expenses Tab**: Expense Categories, Expense Statuses

---

## 🔄 Data Persistence

- The seeders use `firstOrCreate()` which means:
  - ✅ **Safe to run multiple times** - won't create duplicates
  - ✅ **Preserves user modifications** - won't overwrite existing data
  - ✅ **Only adds missing items** - perfect for updates

---

## 🎨 Example Use Cases

### Retail Store
- Use **Physical Store** and **Online Store** channels
- Stock units: **pcs**, **box**, **pack**
- Payment: **cash**, **credit_card**, **mobile_money**

### Service Business
- Product type: **service**
- Payment: **bank_transfer**, **check**
- No stock units needed

### E-commerce
- Channels: **Shopify**, **TikTok**, **Facebook Marketplace**
- Product types: **product**, **digital**
- Units: **pcs**, **kg**, **ltr**

### Multi-Branch Retail
- Channels: **Physical Store**, **2nd Branch**, **Online Store**
- Full inventory tracking with multiple units
- All payment methods enabled

---

## 📊 Summary

**Total Default Data:**
- 4 Product Types
- 8 Units of Measurement
- 13 Payment Methods (Philippines-specific 🇵🇭)
- 5 Payment Statuses
- 4 Expense Statuses
- 10 Product Categories
- 12 Expense Categories
- 7 Sales Channels

**Total: 63 pre-configured items** ready to use! 🎉

---

## 🛠️ Technical Details

### Database Tables
- `business_settings` - Stores types, units, payment methods/statuses, expense statuses
- `product_categories` - Stores product categories
- `expense_categories` - Stores expense categories
- `sales_channels` - Stores sales channels

### Seeder Files
- `DefaultBusinessSettingsSeeder.php`
- `DefaultProductCategoriesSeeder.php`
- `ExpenseCategorySeeder.php`
- `SalesChannelSeeder.php`

### Seeder Order (in `DatabaseSeeder.php`)
1. `BusinessSeeder` - Creates businesses first
2. `DefaultProductCategoriesSeeder` - Product categories
3. `ExpenseCategorySeeder` - Expense categories
4. `DefaultBusinessSettingsSeeder` - Business settings
5. `SalesChannelSeeder` - Sales channels
6. Other demo data seeders...

---

## 🎯 Next Steps

After seeding default data:

1. **Review Settings** - Go to Settings → Business Configuration
2. **Customize** - Add, edit, or remove items to match your business
3. **Add Products** - Start adding products using the pre-configured types and categories
4. **Record Sales** - Use the sales channels and payment methods
5. **Track Expenses** - Use the expense categories and statuses

---

**Need more default data?** Edit the seeder files and re-run them! The `firstOrCreate` method ensures no duplicates.

