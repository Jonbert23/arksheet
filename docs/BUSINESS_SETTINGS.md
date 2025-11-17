# Business Settings Module

## Overview

The Business Settings module allows administrators to manage and configure business-specific information including identity, contact details, and regional settings.

## Features

### 1. Business Identity
- **Business Name** (Required): The official name of your business
- **Founder Name**: Name of the business founder
- **Business Category**: Select from predefined categories (Retail, Wholesale, E-commerce, Services, Manufacturing, Food & Beverage, Technology, Consulting, Other)
- **Date Founded**: The founding date of the business
- **Business Logo**: Upload and display your business logo (Recommended: 200px X 200px)

### 2. Contact Information
- **Phone Number**: Business contact phone
- **Business Email** (Required): Official business email address
- **Website URL**: Business website address
- **Business Address**: Complete business address (textarea for full address)

### 3. Regional Settings
- **Currency** (Required): Select your business's primary currency
  - Supported: USD, EUR, GBP, JPY, CAD, AUD, CHF, CNY, INR, PHP
- **Timezone** (Required): Set your business timezone
  - Supported major timezones across Americas, Europe, Asia, and Australia

### 4. Business Status
- **Active/Inactive Toggle**: Enable or disable business operations
  - When disabled, no transactions can be processed

## Access Control

- **Admin Only**: Only users with admin role can access and modify business settings
- Located in sidebar under "Settings" section

## Routes

- **GET** `/settings/business` - Display business settings form
- **PUT** `/settings/business` - Update business settings

## Files Structure

```
app/
├── Http/
│   └── Controllers/
│       └── SettingsController.php (business, updateBusiness methods)
├── Models/
│   └── Business.php

resources/
└── views/
    └── settings/
        └── business.blade.php

routes/
└── web.php (settings.business, settings.business.update routes)

docs/
└── BUSINESS_SETTINGS.md (this file)
```

## Usage Instructions

### Accessing Business Settings

1. Log in as an admin user
2. Navigate to the sidebar
3. Under "Settings" section, click on "Business Settings"
4. Fill in or update the business information
5. Click "Save Changes" to update

### Logo Upload

1. Click on "Choose File" under Business Logo
2. Select an image file (jpeg, png, jpg, gif, svg - max 2MB)
3. Preview will appear below the upload field
4. Current logo (if exists) will be displayed
5. Save changes to replace the logo

### Form Validation

Required fields are marked with a red asterisk (*):
- Business Name
- Business Email
- Currency
- Timezone

## Storage Setup

Before uploading logos, ensure the storage symlink is created:

```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public`, allowing uploaded logos to be publicly accessible.

## Design Consistency

The Business Settings module follows the existing ArkSheet design patterns:

- **Card Layout**: Uses `.card` with `.radius-12` for consistent border radius
- **Form Controls**: Bootstrap-style form controls with `.radius-8`
- **Color Scheme**: Matches existing primary, danger, and secondary light colors
- **Icons**: Uses Iconify icons consistent with other modules
- **Buttons**: Primary and danger buttons with hover effects
- **Validation**: Inline error messages with Bootstrap validation classes
- **Success Messages**: Alert boxes with dismissible functionality

## Database Fields

The `businesses` table includes:

```php
- id
- name (required)
- slug (auto-generated)
- founder
- category
- date_founded
- logo (file path)
- address
- phone
- email (required)
- website
- currency (required)
- timezone (required)
- settings (JSON)
- is_active (boolean)
- created_at
- updated_at
- deleted_at (soft delete)
```

## Security Considerations

1. **Authentication**: Routes are protected with `auth` middleware
2. **Authorization**: Only admin users can access the settings
3. **File Upload Validation**: 
   - Only image files allowed
   - Maximum file size: 2MB
   - Validated file types: jpeg, png, jpg, gif, svg
4. **Input Validation**: All inputs are validated before saving
5. **Old File Cleanup**: Previous logo is deleted when new one is uploaded

## Future Enhancements

Potential features to add:
- Multiple logo variants (light/dark theme)
- Additional business metadata fields
- Business documents upload
- Multiple business locations
- Business hours configuration
- Tax configuration settings
- Invoice customization settings
- Email notification preferences

## Troubleshooting

### Logo Not Displaying

**Problem**: Uploaded logo doesn't show
**Solution**: 
1. Ensure storage symlink is created: `php artisan storage:link`
2. Check file permissions on `storage/app/public/business-logos`
3. Verify `APP_URL` in `.env` is correct

### Cannot Access Business Settings

**Problem**: Menu item doesn't appear or access denied
**Solution**:
1. Ensure logged-in user has admin role
2. Check `isAdmin()` method in User model
3. Verify middleware is properly configured

### Form Validation Errors

**Problem**: Form shows validation errors
**Solution**:
1. Check all required fields are filled (marked with *)
2. Ensure email is valid format
3. Verify website URL includes protocol (http:// or https://)
4. Confirm logo file is image format and under 2MB

## Support

For additional help or feature requests, please refer to the main documentation or contact the development team.

