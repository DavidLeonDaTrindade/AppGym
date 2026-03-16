FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y git unzip libicu-dev libzip-dev \
    && docker-php-ext-install pdo_mysql intl zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

CMD ["apache2-foreground"]
