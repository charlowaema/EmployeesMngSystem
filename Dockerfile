# -------------------------------------------------
# Stage 1: Build Laravel Vite assets
# -------------------------------------------------
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json* ./

RUN npm install

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

RUN npm run build


# -------------------------------------------------
# Stage 2: Laravel application
# -------------------------------------------------
FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html

# Copy Laravel application
COPY . .

# Copy compiled Vite assets from Node stage
COPY --from=frontend /app/public/build ./public/build

# Laravel configuration
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# Production configuration
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

ENV COMPOSER_ALLOW_SUPERUSER=1

CMD ["/start.sh"]