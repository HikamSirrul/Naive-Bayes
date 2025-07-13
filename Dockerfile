FROM php:8.2-fpm

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev \
    default-libmysqlclient-dev \
    && docker-php-ext-install pdo pdo_mysql gd zip

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy semua file project ke container
COPY . .

# Install dependency Laravel
RUN composer install --optimize-autoloader --no-dev

# Set permission folder Laravel
RUN chmod -R 775 storage bootstrap/cache

# Expose port untuk Laravel
EXPOSE 8000

# Jalankan Laravel saat container run
CMD php artisan config:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT}
