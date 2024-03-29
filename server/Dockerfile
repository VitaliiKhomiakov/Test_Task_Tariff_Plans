FROM php:8.3.3-fpm

RUN apt-get update \
    && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev libzip-dev \
    && docker-php-ext-install pdo zip pdo_mysql \
    && docker-php-ext-configure zip

# Установка Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && composer --version

WORKDIR /var/www/html/tariffs

COPY app/composer.json app/composer.lock ./
RUN composer install

CMD ["php-fpm"]
