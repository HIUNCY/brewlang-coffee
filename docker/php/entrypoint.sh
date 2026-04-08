#!/bin/sh
set -e

# Change into the application directory
cd /var/www/html

# 1. Ensure the .env file exists
if [ ! -f ".env" ]; then
    echo ">>> Creating .env from .env.docker..."
    cp .env.docker .env
fi

# 2. Handle Application Key
# Only generate a key if one doesn't exist to prevent session invalidation on restart
if ! grep -q "APP_KEY=base64:" .env; then
    echo ">>> Generating application key..."
    php artisan key:generate --no-interaction
else
    echo ">>> Application key already exists."
fi

# 3. Handle PHP Dependencies
# In production, this is done in the Dockerfile.
# In dev, we only run it if the vendor folder is missing (e.g., first run with empty volume)
if [ ! -d "vendor" ]; then
    echo ">>> Vendor directory not found. Running composer install..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# 4. Database Setup
echo ">>> Running database migrations..."
php artisan migrate --force --no-interaction

# 5. Symbolic Links
if [ ! -L "public/storage" ]; then
    echo ">>> Linking storage..."
    php artisan storage:link --no-interaction --force
fi

# 6. Clear caches to prevent stale configurations
# We use config:cache in production, but for dev, we just ensure no stale cache remains
echo ">>> Clearing application caches..."
php artisan config:clear
php artisan cache:clear

# 7. Start the server
echo ">>> Starting Brewlang application..."
exec php artisan serve --host=0.0.0.0 --port=8000
