# ==========================================
# Stage 1: PHP Composer Dependencies
# ==========================================
FROM php:8.2-cli-alpine AS composer-stage

WORKDIR /var/www

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install system dependencies
RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    postgresql-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip intl pdo_pgsql pgsql bcmath opcache

# Copy dependency files
COPY composer.json composer.lock ./

# Install dependencies without autoloader generation
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist --no-autoloader

# Copy the rest of the application code
COPY . .

# Generate optimized autoloader with all classes present
RUN composer dump-autoload --no-dev --optimize

# ==========================================
# Stage 2: Node.js Asset Compilation
# ==========================================
FROM node:20-alpine AS node-stage

WORKDIR /var/www

# Copy all files for asset compilation (Vite needs views and config to compile Tailwind/Vite assets)
COPY . .

# Copy vendor dependencies from Composer stage (Vite / Tailwind needs vendor/filament/filament/... to compile theme)
COPY --from=composer-stage /var/www/vendor ./vendor

# Install dependencies and build assets
RUN npm install --include=dev
RUN npm run build

# ==========================================
# Stage 3: Final Production Image
# ==========================================
FROM php:8.2-fpm-alpine

WORKDIR /var/www

# Install system dependencies & web server
RUN apk add --no-cache \
    nginx \
    supervisor \
    libzip \
    libpng \
    libjpeg-turbo \
    freetype \
    icu-libs \
    postgresql-libs \
    postgresql-client

# Install PHP extensions
RUN apk add --no-cache --virtual .build-deps \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip intl pdo_pgsql pgsql bcmath opcache \
    && apk del .build-deps

# Copy custom configurations
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Make entrypoint executable
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copy application files (with correct ownership)
COPY --chown=www-data:www-data . .

# Copy vendor dependencies from Composer stage
COPY --from=composer-stage --chown=www-data:www-data /var/www/vendor ./vendor

# Copy public assets from Node stage
COPY --from=node-stage --chown=www-data:www-data /var/www/public/build ./public/build

# Set permissions for storage & bootstrap cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose port 80
EXPOSE 80

# Set entrypoint and default start command
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
