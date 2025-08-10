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

# Copy file dependency Node.js terlebih dahulu (untuk cache Docker layer)
COPY package.json package-lock.json ./
COPY vite.config.js tailwind.config.js postcss.config.js ./

# Install Node.js (untuk Vite & Tailwind)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm

# Install dependencies Vite/Tailwind
RUN npm install

# Copy semua file project
COPY . .

# Copy environment
COPY .env.railway .env

# Install dependency PHP
RUN composer install --optimize-autoloader --no-dev

# Build Vite (production)
RUN npm run build

# Permission storage
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD php artisan config:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT}
