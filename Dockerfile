FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    $PHPIZE_DEPS \
    libssl-dev \
    pkg-config \
    unzip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite headers

WORKDIR /var/www/html

COPY docker/apache/000-default.conf \
    /etc/apache2/sites-available/000-default.conf