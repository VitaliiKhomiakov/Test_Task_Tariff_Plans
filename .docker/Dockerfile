FROM php:8.4.13-fpm-alpine

# Установка системных зависимостей
RUN apk add --no-cache \
        curl-dev \
        pkgconfig \
        openssl-dev \
        libzip-dev \
        oniguruma-dev \
        libxml2-dev \
        unzip \
        git \
        autoconf \
        g++ \
        make

# Установка PHP расширений
RUN docker-php-ext-configure zip \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        zip \
        mbstring \
        xml \
        curl

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Настройка рабочей директории
WORKDIR /var/www/html/tariffs

# Копирование файлов зависимостей
COPY composer.json composer.lock ./

# Установка зависимостей
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Копирование исходного кода
COPY . .

# Настройка прав доступа
RUN chown -R www-data:www-data /var/www/html/tariffs \
    && chmod -R 755 /var/www/html/tariffs

# Настройка PHP-FPM
RUN echo "pm.max_children = 20" >> /usr/local/etc/php-fpm.d/www.conf \
    && echo "pm.start_servers = 5" >> /usr/local/etc/php-fpm.d/www.conf \
    && echo "pm.min_spare_servers = 5" >> /usr/local/etc/php-fpm.d/www.conf \
    && echo "pm.max_spare_servers = 10" >> /usr/local/etc/php-fpm.d/www.conf

CMD ["php-fpm"]