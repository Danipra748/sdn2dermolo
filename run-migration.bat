@echo off
echo ========================================
echo   Running Migration for Hero Image
echo ========================================
echo.

cd c:\laragon\www\sdnegeri2dermolo

echo Step 1: Running migration...
php artisan migrate

echo.
echo Step 2: Clearing all caches...
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear

echo.
echo Step 3: Creating storage symlink...
php artisan storage:link

echo.
echo ========================================
echo   Setup Complete!
echo ========================================
echo.
echo You can now upload hero images from admin panel.
echo URL: http://127.0.0.1:8000/admin/hero-image
echo.
pause
