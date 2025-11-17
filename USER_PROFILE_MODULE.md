# User Profile Module - Complete Setup Guide

## Overview
The User Profile module allows users to manage their personal information, change passwords, and upload avatars.

## Features Implemented ✅

### 1. **Profile Management**
- View and edit personal information (Name, Email, Phone)
- Display user role and business association
- Display account status

### 2. **Password Management**
- Change password with current password verification
- Password confirmation validation
- Minimum 8 characters requirement
- Toggle password visibility

### 3. **Avatar Upload**
- Upload profile picture (JPEG, JPG, PNG)
- Real-time image preview
- Maximum file size: 2MB
- Automatic old avatar cleanup
- Default avatar fallback

### 4. **Security**
- Current password verification for password changes
- Unique email validation
- Protected routes (authentication required)
- Automatic CSRF protection

## File Structure

```
app/
├── Http/
│   └── Controllers/
│       └── ProfileController.php         # Profile management controller
└── Models/
    └── User.php                         # User model (with avatar support)

resources/
└── views/
    └── profile/
        └── index.blade.php              # Main profile page

routes/
└── web.php                              # Profile routes

database/
└── migrations/
    └── 2025_11_11_093053_update_users_table_add_business_fields.php  # Includes avatar column
```

## Routes

| Method | Route | Name | Description |
|--------|-------|------|-------------|
| GET | `/profile` | `profile.index` | View profile page |
| PUT | `/profile/update` | `profile.update` | Update profile information |
| PUT | `/profile/password` | `profile.password.update` | Change password |
| POST | `/profile/avatar` | `profile.avatar.update` | Upload avatar |
| DELETE | `/profile/avatar` | `profile.avatar.delete` | Remove avatar |

## Access Points

### 1. **Navbar Dropdown**
- Click user avatar in top-right corner
- Select "My Profile" (Soon badge removed ✅)

### 2. **Direct URL**
```
http://localhost/arksheet/profile
```

### 3. **Blade Template**
```blade
<a href="{{ route('profile.index') }}">My Profile</a>
```

## Setup Instructions

### 1. **Storage Link (REQUIRED)**
The profile module uses Laravel's storage system for avatar uploads. You need to create a symbolic link:

```bash
# Run this command in your project root
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public`.

### 2. **Directory Structure**
After running `storage:link`, avatars will be stored at:
```
storage/app/public/avatars/
```

And accessible via:
```
public/storage/avatars/
```

### 3. **Migrations**
Ensure all migrations are run:
```bash
php artisan migrate
```

The `avatar` column is added by migration: `2025_11_11_093053_update_users_table_add_business_fields.php`

## Usage Guide

### For Users

#### **Editing Profile**
1. Navigate to your profile (click avatar → My Profile)
2. Edit Profile tab is active by default
3. Update your information:
   - Full Name (required)
   - Email (required, must be unique)
   - Phone (optional)
4. Click "Save Changes"

#### **Uploading Avatar**
1. In Edit Profile tab
2. Click camera icon on profile image
3. Select image (JPEG, JPG, PNG, max 2MB)
4. Image updates automatically
5. Avatar appears in navbar immediately

#### **Changing Password**
1. Switch to "Change Password" tab
2. Enter current password
3. Enter new password (min. 8 characters)
4. Confirm new password
5. Click "Change Password"

### For Developers

#### **Displaying User Avatar**
```blade
<!-- With fallback -->
<img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('assets/images/user.png') }}" 
     alt="{{ $user->name }}">

<!-- In navbar (already implemented) -->
<img src="{{ auth()->user()->avatar ?? asset('assets/images/user.png') }}" 
     alt="{{ auth()->user()->name }}">
```

#### **Checking User Role**
```blade
@if(auth()->user()->isAdmin())
    <!-- Admin only content -->
@endif
```

#### **Profile Controller Methods**

**index()** - Display profile page
```php
public function index()
{
    $user = Auth::user();
    return view('profile.index', compact('user'));
}
```

**update()** - Update profile information
```php
public function update(Request $request)
{
    // Validates: name, email, phone
    // Updates user information
    // Redirects with success message
}
```

**updatePassword()** - Change password
```php
public function updatePassword(Request $request)
{
    // Validates: current_password, password, password_confirmation
    // Updates hashed password
    // Redirects with success message
}
```

**updateAvatar()** - Upload avatar (AJAX)
```php
public function updateAvatar(Request $request)
{
    // Validates image file
    // Deletes old avatar
    // Stores new avatar
    // Returns JSON response with new URL
}
```

## Validation Rules

### Profile Update
- `name`: required, string, max:255
- `email`: required, email, unique (except current user)
- `phone`: nullable, string, max:20

### Password Change
- `current_password`: required, must match user's current password
- `password`: required, confirmed, minimum 8 characters

### Avatar Upload
- `avatar`: required, image file, mimes:jpeg,jpg,png, max:2048KB

## Success Messages
All form submissions show success messages:
- ✅ "Profile updated successfully!"
- ✅ "Password changed successfully!"
- ✅ "Avatar updated successfully!"

## Error Handling
- Validation errors displayed inline with form fields
- File upload errors shown via toastr notification
- Password mismatch errors highlighted
- Email uniqueness validation

## Security Features
1. **Authentication Required**: All profile routes require user login
2. **CSRF Protection**: All POST/PUT/DELETE requests include CSRF tokens
3. **Current Password Verification**: Required for password changes
4. **Password Hashing**: Passwords stored using bcrypt hashing
5. **File Type Validation**: Only image files allowed for avatars
6. **File Size Limit**: Maximum 2MB for avatars

## UI Components

### Tabs
- **Edit Profile**: Personal information and avatar
- **Change Password**: Password change form

### Form Elements
- Text inputs with validation
- Password fields with visibility toggle
- File upload with preview
- Action buttons (Cancel/Save)

### Design Features
- Responsive layout (4-8 column grid)
- Profile card with background image
- Personal info sidebar
- Role badge display
- Active status indicator
- Success/error alerts with auto-dismiss

## Browser Support
- Modern browsers (Chrome, Firefox, Safari, Edge)
- Requires JavaScript for:
  - Image preview
  - Password visibility toggle
  - AJAX avatar upload
  - Form validation feedback

## Dependencies
- Laravel 11.x
- jQuery (for AJAX and DOM manipulation)
- Bootstrap 5 (for styling)
- Iconify (for icons)
- Toastr (for notifications)

## Testing Checklist

- [ ] Navigate to profile page
- [ ] View personal information
- [ ] Update name and email
- [ ] Add/update phone number
- [ ] Upload avatar (image preview works)
- [ ] Avatar appears in navbar
- [ ] Change password (with correct current password)
- [ ] Change password fails with wrong current password
- [ ] Password confirmation works
- [ ] Form validation displays errors
- [ ] Success messages appear
- [ ] Role and business display correctly
- [ ] Settings link (admin only) works

## Troubleshooting

### Avatar Not Uploading
**Problem**: Avatar upload fails or doesn't display
**Solutions**:
1. Run `php artisan storage:link`
2. Check `storage/app/public/avatars` permissions
3. Verify file size is under 2MB
4. Check file type (must be JPEG, JPG, or PNG)

### Image Not Displaying
**Problem**: Avatar shows broken image
**Solutions**:
1. Verify storage link exists: `public/storage` → `storage/app/public`
2. Check file exists in `storage/app/public/avatars`
3. Verify web server can read storage directory
4. Clear browser cache

### Password Change Fails
**Problem**: "Current password is incorrect" error
**Solutions**:
1. Ensure you're entering the correct current password
2. Check if password was changed elsewhere
3. Verify password field is not disabled

### Profile Not Accessible
**Problem**: Cannot access profile page
**Solutions**:
1. Ensure you're logged in
2. Check routes: `php artisan route:list | grep profile`
3. Verify ProfileController exists
4. Check for middleware blocking access

## Future Enhancements (Optional)

### Possible Additions
- [ ] Two-factor authentication setup
- [ ] Notification preferences (already designed, not implemented)
- [ ] Activity log (recent logins, changes)
- [ ] Export personal data
- [ ] Delete account option
- [ ] Social media links
- [ ] Biography/description field
- [ ] Email verification
- [ ] Profile visibility settings
- [ ] Profile completion percentage

## Support
For issues or questions:
1. Check this documentation
2. Review validation errors
3. Check Laravel logs: `storage/logs/laravel.log`
4. Verify database migrations are complete

---

**Created**: November 17, 2025  
**Version**: 1.0  
**Status**: ✅ Fully Functional

