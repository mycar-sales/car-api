FROM php:8.0-fpm

WORKDIR /var/www/api

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    libonig-dev \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    zip \
    zlib1g-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalação do PHPUnit e Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

ENV XDEBUG_MODE coverage

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /var/www/api

USER www-data

COPY ./api/* /var/www/api

EXPOSE 9000

CMD ["php-fpm"]
