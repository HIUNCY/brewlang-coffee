#!/bin/sh
set -e

# Change into the application directory
cd /var/www/html

# 1. Ensure the .env file exists
if [ ! -f ".env" ]; then
    echo ">>> Creating .env from .env.docker..."
    cp .env.docker .env
fi

# 2. Install PHP dependencies
# In production, this should be done in the Dockerfile, but for local dev, we ensure it's here
echo ">>> Running composer install..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# 3. Handle Application Key
echo ">>> Generating application key..."
php artisan key:generate --no-interaction --force

# 4. Database Setup
echo ">>> Running database migrations..."
php artisan migrate --force --no-interaction

# 5. Symbolic Links
echo ">>> Linking storage..."
php artisan storage:link --no-interaction --force

# 6. Clear all caches to prevent stale configurations
echo ">>> Clearing application caches (config, cache, route, view)..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 7. Start the server
echo ">>> Starting Brewlang application..."
exec php artisan serve --host=0.0.0.0 --port=8000
