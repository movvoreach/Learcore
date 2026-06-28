#!/bin/sh

# Exit on error
set -e

# Run migrations if database is ready (optional/configurable via ENV)
if [ "${RUN_MIGRATIONS}" = "true" ]; then
    echo "Running migrations..."
    php artisan migrate --force
fi

# Cache config, routes, views, and filament icons/components
echo "Optimizing Laravel installation..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Execute the main supervisord command
exec "$@"
