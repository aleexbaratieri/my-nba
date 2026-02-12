FROM php:8.3.12-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    cron \
    supervisor \
    curl \
    git \
    zip unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    openssl \
    libicu-dev \
    ghostscript \
    chromium \
    libnss3 \
    libatk-bridge2.0-0 \
    libxss1 \
    libasound2 \
    libatk1.0-0 \
    libgbm1 \
    libxcomposite1 \
    libxdamage1 \
    libxrandr2 \
    libpango-1.0-0 \
    libcups2 \
    libxshmfence1 \
    libxfixes3 \
    libxtst6 \
    libxcb1 \
    libx11-xcb1 \
    libdrm2 \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        bcmath \
        curl \
        mbstring \
        pdo \
        pdo_mysql \
        gd \
        zip \
        exif \
        intl \
    && docker-php-ext-enable exif

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends $PHPIZE_DEPS; \
    pecl install redis; \
    docker-php-ext-enable redis; \
    apt-get purge -y --auto-remove $PHPIZE_DEPS; \
    rm -rf /var/lib/apt/lists/* /tmp/pear

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json ./
RUN composer install --no-scripts --no-interaction

COPY . .

COPY ./.docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./.docker/php-fpm/php.ini /usr/local/etc/php/
COPY ./.docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./.docker/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN mkdir -p /run/nginx

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]