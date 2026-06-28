#!/bin/sh

# Exit on error
set -e

# Render exposes managed PostgreSQL through DATABASE_URL. Make sure Laravel uses
# the runtime value even when individual DB_* variables are not configured.
if [ -n "${DATABASE_URL}" ] && [ -z "${DB_CONNECTION}" ]; then
    export DB_CONNECTION=pgsql
fi

if [ "${DB_CONNECTION}" = "pgsql" ] && [ -z "${DB_SSLMODE}" ]; then
    export DB_SSLMODE=require
fi

# Remove any stale framework caches before reading runtime environment values.
php artisan optimize:clear

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
