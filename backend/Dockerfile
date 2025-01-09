# Dockerfile (backend)
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev \
    && docker-php-ext-install zip pdo_mysql

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/html
COPY ./api /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 8000

CMD ["symfony", "server:start", "--no-tls", "--port=8000", "--dir=/var/www/html", "--allow-all-ip"]

