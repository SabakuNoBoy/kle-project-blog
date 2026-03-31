FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libicu-dev

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip

RUN echo "upload_max_filesize = 128M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 128M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 512M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 600" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_input_time = 600" >> /usr/local/etc/php/conf.d/uploads.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# We run composer install in docker-compose command array to utilize mapped volume appropriately when developing
