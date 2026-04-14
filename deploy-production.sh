#!/bin/bash

# SDN 2 Dermolo - Production Deployment Script
# This script handles logo upload fixes for production servers

echo "🚀 Starting deployment for logo upload fix..."

# 1. Create storage symlink if not exists
echo "📦 Checking storage symlink..."
if [ ! -L "public/storage" ]; then
    echo "⚠️  Storage symlink not found. Creating..."
    php artisan storage:link
    echo "✅ Storage symlink created."
else
    echo "✅ Storage symlink already exists."
fi

# 2. Create logo directory if not exists
echo "📁 Checking logo directory..."
if [ ! -d "storage/app/public/school-profile" ]; then
    echo "⚠️  Logo directory not found. Creating..."
    mkdir -p storage/app/public/school-profile
    echo "✅ Logo directory created."
else
    echo "✅ Logo directory already exists."
fi

# 3. Set correct permissions for Linux
echo "🔧 Setting permissions..."
chmod -R 775 storage/app/public/school-profile
chmod 664 storage/app/public/school-profile/* 2>/dev/null || true
echo "✅ Permissions set."

# 4. Set correct owner (www-data for Apache/Nginx)
echo "👤 Setting file ownership..."
chown -R www-data:www-data storage/app/public/school-profile 2>/dev/null || {
    echo "⚠️  Could not set ownership to www-data. Try running with sudo."
}
echo "✅ File ownership set."

# 5. Clear Laravel cache
echo "🧹 Clearing Laravel cache..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo "✅ Cache cleared."

# 6. Restart PHP-FPM if it exists
echo "🔄 Restarting PHP-FPM..."
if systemctl is-active --quiet php8.1-fpm; then
    sudo systemctl restart php8.1-fpm
    echo "✅ PHP-FPM 8.1 restarted."
elif systemctl is-active --quiet php8.0-fpm; then
    sudo systemctl restart php8.0-fpm
    echo "✅ PHP-FPM 8.0 restarted."
elif systemctl is-active --quiet php-fpm; then
    sudo systemctl restart php-fpm
    echo "✅ PHP-FPM restarted."
else
    echo "⚠️  PHP-FPM not found. Please restart manually."
fi

# 7. Verify setup
echo "✅ Verifying setup..."
if [ -d "public/storage" ]; then
    echo "✅ Symlink: OK"
else
    echo "❌ Symlink: MISSING - Run: php artisan storage:link"
fi

if [ -d "storage/app/public/school-profile" ]; then
    echo "✅ Logo Directory: OK"
else
    echo "❌ Logo Directory: MISSING - Run: mkdir -p storage/app/public/school-profile"
fi

if [ -w "storage/app/public/school-profile" ]; then
    echo "✅ Permissions: Writable"
else
    echo "❌ Permissions: Not Writable - Run: chmod -R 775 storage/app/public/school-profile"
fi

echo "🎉 Deployment complete!"
echo ""
echo "📝 Next steps:"
echo "1. Test logo upload in admin panel"
echo "2. Verify logo appears on website"
echo "3. Check error logs if issues persist: tail -f storage/logs/laravel.log"
