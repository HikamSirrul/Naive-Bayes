# Gunakan image PHP dengan ekstensi yang dibutuhkan
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libmysqlclient-dev \
    && docker-php-ext-install pdo pdo_mysql gd zip

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy semua file project ke container
COPY . .

# Install dependency Laravel
RUN composer install --optimize-autoloader --no-dev

# Copy .env.example ke .env jika .env tidak ada
RUN [ ! -f .env ] && cp .env.example .env || true

# Generate APP_KEY jika belum ada
RUN php artisan key:generate --ansi || true

# Set permission storage dan bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Expose port 8000
EXPOSE 8000

# Command untuk menjalankan Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
