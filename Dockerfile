FROM php:8.3.6-fpm-alpine

WORKDIR /var/www/html

# Instalar dependências para compilar extensões PHP
RUN apk --no-cache add $PHPIZE_DEPS linux-headers && \
    pecl install xdebug && \
    docker-php-ext-install pdo pdo_mysql && \
    docker-php-ext-enable xdebug && \
    apk --no-cache del $PHPIZE_DEPS

COPY ["composer.json", "composer.lock", "./"]

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-interaction
RUN mkdir -p /var/www/html/logs && chown -R www-data:www-data /var/www/html/logs
# Rodar composer install já na imagem para evitar isso toda vez no container
COPY . ./

RUN php ./database/migrate.php

