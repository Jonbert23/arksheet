@echo off
echo ========================================
echo Business Settings Module Setup
echo ========================================
echo.

echo Step 1: Creating storage symlink...
php artisan storage:link
echo.

echo Step 2: Creating business-logos directory...
if not exist "storage\app\public\business-logos" mkdir storage\app\public\business-logos
echo.

echo Step 3: Setting permissions...
echo Please ensure the following directories are writable:
echo   - storage/app/public/business-logos
echo   - storage/logs
echo.

echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo You can now access Business Settings at:
echo http://localhost/arksheet/settings/business
echo.
echo Note: You must be logged in as an Admin user.
echo.

pause

