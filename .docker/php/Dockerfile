FROM php:8.2-fpm-alpine

# install necessary alpine packages
RUN apk update && apk add --no-cache \
    linux-headers \
    bash \
    zip \
    unzip \
    dos2unix \
    supervisor \
    libpng-dev \
    libzip-dev \
    freetype-dev \
    $PHPIZE_DEPS \
    libjpeg-turbo-dev

# compile native PHP packages
RUN docker-php-ext-install \
    gd \
    pcntl \
    bcmath \
    mysqli \
    pdo_mysql

# configure packages
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# install additional packages from PECL
RUN pecl install zip && docker-php-ext-enable zip \
    && pecl install igbinary && docker-php-ext-enable igbinary \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && yes | pecl install redis && docker-php-ext-enable redis

COPY php.ini /usr/local/etc/php/conf.d/docker-php-memlimit.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && chmod +x /usr/bin/composer

RUN rm /var/cache/apk/*

COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]

WORKDIR /app
RUN chown -R www-data:www-data /app

