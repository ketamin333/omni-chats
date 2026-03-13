FROM php:8.4-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    gcc \
    make \
    && docker-php-ext-install opcache pdo pdo_pgsql

RUN pecl install redis && docker-php-ext-enable redis

COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
