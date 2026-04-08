FROM php:8.4-fpm-alpine

# 1. Install system dependencies
# We group them and use --no-cache to keep the image slim
RUN apk add --no-cache \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    unzip \
    git \
    nodejs \
    npm \
    sqlite-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_sqlite gd bcmath opcache

# 2. Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 3. Cache Composer dependencies
# By copying only these files first, Docker can cache the 'composer install' layer
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-scripts --no-autoloader --prefer-dist

# 4. Copy the rest of the application
COPY . .

# 5. Finalize Composer
RUN composer dump-autoload --optimize

# 6. Entrypoint setup
COPY docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
