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

RUN composer install --optimize-autoloader --no-dev
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD php artisan config:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT}
