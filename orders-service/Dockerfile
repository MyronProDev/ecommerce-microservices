FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev git unzip zip curl libonig-dev libxml2-dev librabbitmq-dev \
    && pecl install amqp
RUN docker-php-ext-install pdo pdo_pgsql && docker-php-ext-enable amqp

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

CMD ["php-fpm"]