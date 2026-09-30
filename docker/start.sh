#!/bin/sh

echo "Starting Laravel application..."

php artisan config:cache

php artisan route:cache

php artisan migrate --force

php-fpm -D

nginx -g "daemon off;"