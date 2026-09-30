# -------------------------------------------------
# Stage 1: Install Composer dependencies
# -------------------------------------------------
FROM composer:2 AS composer

WORKDIR /app

COPY composer.json composer.lock ./

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
# Stage 3: Laravel + Nginx + PHP-FPM
# -------------------------------------------------
FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html

# Copy Laravel application
COPY . .

# Copy Composer dependencies
COPY --from=composer /app/vendor ./vendor

# Copy compiled Vite assets
COPY --from=frontend /app/public/build ./public/build

# Laravel configuration
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV REAL_IP_HEADER=1

# Production configuration
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

ENV COMPOSER_ALLOW_SUPERUSER=1

CMD ["/start.sh"]