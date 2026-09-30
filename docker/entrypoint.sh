#!/bin/bash
set -e

echo "Starting Employee Mng System..."

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Clear only file-based caches (safe before DB exists)
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Drop all tables and re-run migrations fresh
# This is safe because Render DB has no real data yet
echo "Running fresh migrations..."
#php artisan migrate:fresh --force --no-interaction
php artisan migrate --force --no-interaction

# Clear database cache (now safe - tables exist)
php artisan cache:clear || true


# Cache for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage symlink
php artisan storage:link 2>/dev/null || true

# Permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Log directories
mkdir -p /var/log/nginx /var/log/php-fpm /var/log/supervisor
touch /var/log/worker.log


" 2>/dev/null || true

echo "Setup complete. Starting services..."

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

