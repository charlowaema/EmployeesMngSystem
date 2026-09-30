# -------------------------------------------------
# Stage 1: Composer dependencies
# -------------------------------------------------
FROM composer:2 AS composer

WORKDIR /app

COPY . .

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader


# -------------------------------------------------
# Stage 2: Build Vite assets
# -------------------------------------------------
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

RUN npm run build


# -------------------------------------------------
# Stage 3: PHP 8.3 + Nginx
# -------------------------------------------------
FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

# Install required system packages
RUN apk add --no-cache \
    nginx \
    postgresql-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    icu-dev \
    bash

# Install PHP extensions required by Laravel/PostgreSQL
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    xml \
    bcmath \
    intl \
    opcache

# Copy Laravel application
COPY . .

# Copy Composer dependencies
COPY --from=composer /app/vendor ./vendor

# Copy Vite build
COPY --from=frontend /app/public/build ./public/build

# Laravel production settings
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

ENV WEBROOT=/var/www/html/public

# Permissions
RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache

# Nginx configuration
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Start script
COPY docker/start.sh /start.sh

RUN chmod +x /start.sh

EXPOSE 10000

CMD ["/start.sh"]