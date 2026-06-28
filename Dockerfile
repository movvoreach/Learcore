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

# ===============================
# FIX: copy FULL project BEFORE install
# ===============================
COPY . .

# Install PHP dependencies
RUN composer config --global process-timeout 2000 \
    && composer install \
    --no-dev \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction \
    --ignore-platform-reqs


# ==========================================
# Stage 2: Node Build (Vite / Tailwind)
# ==========================================
FROM node:20-alpine AS node

WORKDIR /var/www

# Copy full project
COPY . .

# Copy vendor from composer stage
COPY --from=composer /var/www/vendor ./vendor

# Install dependencies
RUN npm install

# Build assets
RUN npm run build


# ==========================================
# Stage 3: Production
# ==========================================
FROM php:8.2-fpm-alpine

WORKDIR /var/www

# Install runtime packages
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

# Install PHP extensions
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

# Copy vendor from composer stage
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