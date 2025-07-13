#!/bin/bash

echo "🚀 Installing dependencies..."
composer install --no-dev --optimize-autoloader

echo "🔑 Generating app key..."
php artisan key:generate

echo "⚙️ Caching config, route, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🗃️ Running database migrations..."
php artisan migrate --force

echo "🌐 Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=${PORT}
