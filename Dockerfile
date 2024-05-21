FROM php:8.1-fpm

# Set environment variable to allow superuser for Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# ... (other Dockerfile configurations)

WORKDIR /var/www/html

# Copy the local codebase to the container
COPY . .

# Install dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-interaction
