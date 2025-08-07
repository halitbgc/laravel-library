# Laravel için PHP imajı
FROM php:8.2-fpm

# Gerekli paketleri yükle
RUN apt-get update && apt-get install -y \
    sqlite3 libsqlite3-dev \
    libzip-dev unzip \
    curl git \
    && docker-php-ext-install pdo pdo_sqlite zip

# Composer kurulumu
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Laravel için izinler
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www
