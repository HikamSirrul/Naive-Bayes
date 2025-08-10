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

WORKDIR /var/www

# Copy project
COPY . .
COPY .env.railway .env

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev
RUN chmod -R 775 storage bootstrap/cache

# Install Node.js (untuk Vite & Tailwind)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm

# Install dependencies Vite/Tailwind
RUN npm install

# Build assets Vite/Tailwind
RUN npm run build

EXPOSE 8000

# Jalankan Laravel setelah semua build selesai
CMD php artisan config:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT}
