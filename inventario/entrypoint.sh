#!/bin/sh

# Prepare writable Laravel runtime directories.
mkdir -p /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

# Ensure Apache can write runtime files.
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Keep startup side-effect-free: dependency installation, key generation,
# storage linking, and database migrations must be explicit operator actions.
exec "$@"
