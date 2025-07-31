FROM php:8.2-cli

WORKDIR /var/www/my-bookshelf

COPY . .

# Instalar dependências para compilar extensões PHP
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libsqlite3-dev \
    default-mysql-client \
    unzip git zip \
    build-essential \
    autoconf \
    pkg-config \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install xml pdo_mysql pdo_sqlite

# Instalar composer via instalador oficial
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependências PHP via composer
RUN composer install

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
