FROM composer:lts AS builder

WORKDIR /var/www/app

COPY composer.lock composer.json /var/www/app/

RUN composer install --no-dev --no-scripts

FROM php:8.3-fpm-alpine AS runner

WORKDIR /var/www/app

COPY --from=builder /var/www/app/vendor /var/www/app/vendor

RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    postgresql-dev && \
    docker-php-ext-install pdo pdo_pgsql zip && \
    rm -rf /var/cache/apk/* && \
    addgroup -g 1000 www && \
    adduser -u 1000 -S www -G www && \
    chown -R www:www /var/www

COPY --chown=www:www . /var/www/app

USER www

EXPOSE 9000
CMD ["php-fpm"]
