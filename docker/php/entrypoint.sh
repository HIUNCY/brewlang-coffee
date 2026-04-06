#!/bin/sh
set -e

cd /var/www/html

composer install --no-interaction --prefer-dist --optimize-autoloader

if [ ! -f ".env" ]; then
    cp .env.docker .env
fi

php artisan key:generate --no-interaction 2>/dev/null || true

if [ -z "$APP_KEY" ]; then
    export APP_KEY=$(grep '^APP_KEY=' .env | cut -d '=' -f2-)
fi

php artisan migrate --force --no-interaction
php artisan db:seed --force --no-interaction
php artisan storage:link --no-interaction 2>/dev/null || true

php artisan config:clear
php artisan route:clear
php artisan view:clear

exec php artisan serve --host=0.0.0.0 --port=8000
