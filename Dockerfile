# ==========================================
# Stage 1: Composer Dependencies
# ==========================================
FROM php:8.2-cli-alpine AS composer

WORKDIR /var/www

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install system dependencies
RUN apk add --no-cache \
    git \
    unzip \
    icu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    postgresql-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    bcmath \
    intl \
    zip \
    gd \
    opcache

# Copy Composer files first
COPY composer.json composer.lock ./

# Install PHP packages
RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction

# Copy application
COPY . .

# ==========================================
# Stage 2: Node Build
# ==========================================
FROM node:20-alpine AS node

WORKDIR /var/www

# Copy application
COPY . .

# Copy vendor from Composer stage
COPY --from=composer /var/www/vendor ./vendor

# Install Node packages
RUN npm install

# Build assets
RUN npm run build

# ==========================================
# Stage 3: Production
# ==========================================
FROM php:8.2-fpm-alpine

WORKDIR /var/www

# Install packages
RUN apk add --no-cache \
    nginx \
    supervisor \
    icu-libs \
    libzip \
    libpng \
    libjpeg-turbo \
    freetype \
    postgresql-libs \
    postgresql-client

# Build dependencies
RUN apk add --no-cache --virtual .build-deps \
    icu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    bcmath \
    intl \
    zip \
    gd \
    opcache \
    && apk del .build-deps

# Copy configs
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

# Copy application
COPY --chown=www-data:www-data . .

# Copy vendor
COPY --from=composer --chown=www-data:www-data /var/www/vendor ./vendor

# Copy built assets
COPY --from=node --chown=www-data:www-data /var/www/public/build ./public/build

# Permissions
RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord","-c","/etc/supervisor/conf.d/supervisord.conf"]