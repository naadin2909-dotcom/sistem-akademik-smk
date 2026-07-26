#!/bin/bash
set -e

# Create SQLite database if not exists
touch database/database.sqlite
chown www-data:www-data database/database.sqlite

# Run migrations and seed
php artisan migrate --force
php artisan db:seed --force || true

# Clear and cache config
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix storage permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Start PHP-FPM in background
php-fpm -y /usr/local/etc/php-fpm.conf -R &

# Start Nginx in foreground
nginx -g 'daemon off;'
