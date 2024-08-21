FROM php:8.0-fpm

WORKDIR /var/www/api

RUN apt-get update && apt-get install -y \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    zip \
    curl \
    unzip

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./api/* /var/www/api
EXPOSE 9000

CMD ["php-fpm"]