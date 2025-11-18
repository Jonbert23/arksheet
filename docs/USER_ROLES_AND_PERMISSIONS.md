# User Roles and Permissions Structure

## Overview
The application has three distinct user roles, each with specific access levels and capabilities.

---

## 1. 🔴 Super Admin (Application Owner)

**Purpose:** Manages the entire multi-tenant application and oversees all businesses.

### Core Responsibilities:
- Manage all businesses/tenants in the system
- Oversee system-wide operations and health
- Configure application settings and features
- Monitor usage and analytics across all businesses

### Full Access To:

#### Business Management
- ✅ View all businesses/tenants
- ✅ Create new business accounts
- ✅ Edit business information
- ✅ Suspend/Activate business accounts
- ✅ Delete businesses (with confirmation)
- ✅ View business statistics and usage

#### User Management (Global)
- ✅ View all users across all businesses
- ✅ Impersonate any business owner for support
- ✅ Reset passwords for any user
- ✅ Suspend/Activate user accounts
- ✅ View user activity logs

#### System Management
- ✅ Application settings and configuration
- ✅ System-wide reports and analytics
- ✅ Database backups and maintenance
- ✅ Email and notification settings
- ✅ Integration management (payment gateways, etc.)
- ✅ Feature flag management
- ✅ System logs and error monitoring

#### Financial Oversight
- ✅ View all transactions across businesses
- ✅ Subscription management
- ✅ Billing and invoicing
- ✅ Revenue reports

#### Support & Maintenance
- ✅ Access support tickets
- ✅ System announcements
- ✅ Scheduled maintenance
- ✅ Version updates


## 2. 🟠 Business Owner (Tenant Owner)

**Purpose:** Owns and manages their business data and operations within the application.

### Core Responsibilities:
- Manage their business operations
- Create and manage staff users
- Configure business settings
- Monitor business performance

### Full Access To:

#### Dashboard
- ✅ Business overview and key metrics
- ✅ Recent activities
- ✅ Quick statistics
- ✅ Performance charts

#### Inventory Management
- ✅ **Products**
  - Create, view, edit, delete products
  - Manage product categories
  - Set pricing and stock levels
  - View product performance
  
- ✅ **Stock Management**
  - Add stock entries
  - View stock history
  - Adjust stock levels
  - Low stock alerts

#### Sales Management
- ✅ **Sales/POS**
  - Process sales transactions
  - View sales history
  - Refund/void transactions
  - Generate receipts
  
- ✅ **Invoices**
  - Create and manage invoices
  - Send invoices to customers
  - Track payment status
  - Download/print invoices
  
- ✅ **Customers**
  - Add, view, edit, delete customers
  - View customer purchase history
  - Customer analytics
  - Export customer data

#### Financial Management
- ✅ **Expenses**
  - Record expenses
  - Categorize expenses
  - Attach receipts
  - View expense reports
  
- ✅ **Reports**
  - Sales reports
  - Expense reports
  - Financial statements
  - Product performance reports
  - Customer reports
  - Profit/loss analysis
  - Custom date range reports
  - Export reports (PDF, Excel)

#### Business Management
- ✅ **Target Goals**
  - Create sales/revenue goals
  - Track progress
  - View goal analytics
  - Edit/delete goals
  
- ✅ **User Management**
  - Create staff accounts
  - Assign permissions to staff
  - Edit staff information
  - Activate/deactivate staff
  - Delete staff accounts
  - View staff activity logs

#### Settings
- ✅ **Business Settings**
  - Business information
  - Logo and branding
  - Receipt customization
  - Tax settings
  - Currency settings
  
- ✅ **Profile Settings**
  - Update personal information
  - Change password
  - Email preferences
  - Notification settings

### Restrictions:
- ❌ Cannot access other businesses' data
- ❌ Cannot modify application-level settings
- ❌ Cannot delete their own business account (must contact Super Admin)

---

## 3. 🟢 Staff (Employee)

**Purpose:** Assists business owner with specific operations based on assigned permissions.

### Core Responsibilities:
- Perform assigned tasks within their permissions
- Help manage day-to-day operations
- Cannot access sensitive business data unless granted

### Customizable Access (Assigned by Business Owner):

#### Dashboard (Optional)
- ✅ View basic business metrics
- ⚠️ Limited to their assigned areas

#### Inventory Management (Optional)
- ✅ **Products**
  - View products
  - Add new products
  - Edit product information
  - ⚠️ May not delete products (owner discretion)
  
- ✅ **Stock Management**
  - View stock levels
  - Add stock entries
  - ⚠️ Limited to assigned locations/categories

#### Sales Management (Optional)
- ✅ **Sales/POS**
  - Process sales transactions
  - View own sales history
  - ⚠️ Cannot void/refund without permission
  
- ✅ **Invoices**
  - Create invoices
  - View invoices
  - ⚠️ Cannot delete invoices
  
- ✅ **Customers**
  - View customer list
  - Add new customers
  - Update customer information
  - ⚠️ Cannot delete customers

#### Financial Management (Optional)
- ✅ **Expenses**
  - Record daily expenses
  - View expense list
  - ⚠️ Cannot edit/delete expenses (owner only)
  
- ⚠️ **Reports** (View Only)
  - View assigned reports
  - ⚠️ Cannot access financial reports
  - ⚠️ Cannot export sensitive data

#### Business Management
- ❌ **Target Goals** (No Access by default)
  - ⚠️ View only if granted
  
- ❌ **User Management** (No Access)
  - Cannot create or manage other users

#### Settings
- ✅ **Profile Settings Only**
  - Update own information
  - Change own password
  - Email preferences
  
- ❌ **Business Settings** (No Access)
  - Cannot modify business settings

### Default Staff Permissions (Recommended):
```
✅ Dashboard - View only
✅ Products - Full access (add, edit, view)
✅ Stock - Full access
✅ Sales/POS - Full access
✅ Customers - Add, view, edit
❌ Invoices - No access (owner handles)
❌ Expenses - No access (owner handles)
❌ Reports - No access (sensitive data)
❌ Goals - No access
❌ Users - No access
```

### Staff Restrictions:
- ❌ Cannot see financial reports
- ❌ Cannot access other staff information
- ❌ Cannot modify business settings
- ❌ Cannot delete their own account (must contact owner)
- ❌ Cannot access modules not assigned to them
- ❌ Activity may be logged and monitored by owner

---

## Permission Assignment Flow

### For Super Admin:
```
Super Admin → All System Access (Hardcoded)
```

### For Business Owner:
```
Business Owner → All Business Modules (Hardcoded)
```

### For Staff:
```
Business Owner → Create Staff → Select Modules → Staff Gets Custom Access
```

---

## Security Considerations

### Multi-tenancy:
- All users (except Super Admin) are scoped to their `business_id`
- Users cannot access data from other businesses
- Database queries automatically filter by business context

### Password Requirements:
- Minimum 8 characters
- Should include mix of characters (recommended)
- Must confirm password on creation/update

### Session Management:
- Inactive users cannot log in
- Sessions expire after inactivity
- Password reset via email

### Audit Logging (Recommended Future Feature):
- Log all critical actions
- Track who accessed what data
- Monitor staff activities
- Generate compliance reports

---

## Module Access Matrix

| Module | Super Admin | Business Owner | Staff (Default) | Staff (Custom) |
|--------|------------|----------------|-----------------|----------------|
| **System Management** | ✅ Full | ❌ None | ❌ None | ❌ None |
| **Business Management** | ✅ Full | ❌ None | ❌ None | ❌ None |
| **Dashboard** | ✅ All Businesses | ✅ Own Business | ⚠️ Optional | ✅ If Granted |
| **Products** | ⚠️ View Only | ✅ Full | ✅ Full | ✅ If Granted |
| **Stock** | ⚠️ View Only | ✅ Full | ✅ Full | ✅ If Granted |
| **Sales/POS** | ⚠️ View Only | ✅ Full | ✅ Full | ✅ If Granted |
| **Invoices** | ⚠️ View Only | ✅ Full | ❌ None | ✅ If Granted |
| **Customers** | ⚠️ View Only | ✅ Full | ✅ View/Add/Edit | ✅ If Granted |
| **Expenses** | ⚠️ View Only | ✅ Full | ❌ None | ✅ If Granted |
| **Reports** | ✅ System Reports | ✅ All Reports | ❌ None | ⚠️ Limited |
| **Goals** | ⚠️ View Only | ✅ Full | ❌ None | ✅ If Granted |
| **Users** | ✅ All Users | ✅ Own Staff | ❌ None | ❌ None |
| **Settings** | ✅ System | ✅ Business | ✅ Profile Only | ✅ Profile Only |

---

## Implementation Notes

### Database Structure:
```sql
users table:
- id
- business_id (null for Super Admin)
- name
- email
- password
- role (super_admin, business_owner, staff)
- permissions (JSON array for staff)
- is_active
- created_at
- updated_at
```

### Permission Storage Format:
```json
{
  "permissions": [
    "dashboard",
    "products",
    "stock",
    "sales",
    "customers"
  ]
}
```

### Middleware Usage:
```php
// Check if user has module access
Route::middleware(['auth', 'module.permission:products'])->group(function () {
    Route::resource('products', ProductController::class);
});
```

---

## Future Enhancements

### Advanced Features:
- [ ] Custom roles beyond the three tiers
- [ ] Time-based access (shift schedules)
- [ ] Location-based permissions (multi-location businesses)
- [ ] Advanced approval workflows
- [ ] Role templates for quick staff setup
- [ ] Bulk permission updates
- [ ] Permission inheritance
- [ ] Temporary elevated access

### Analytics:
- [ ] User activity dashboard
- [ ] Permission usage reports
- [ ] Staff performance metrics
- [ ] Security audit logs

---

## Questions to Consider

1. **Should Staff be able to:**
   - View profit margins on products?
   - Process refunds without owner approval?
   - See other staff members' sales?
   - Access historical data beyond certain period?

2. **Should Business Owner be able to:**
   - Create read-only staff accounts?
   - Set different permission levels (Level 1, 2, 3)?
   - Temporarily elevate staff permissions?
   - Receive alerts on staff actions?

3. **Should Super Admin have:**
   - A separate admin panel?
   - Ability to create demo businesses?
   - Bulk operations on businesses?
   - White-label configuration options?

---

**Document Version:** 1.0  
**Last Updated:** November 14, 2025  
**Status:** Pending Implementation

