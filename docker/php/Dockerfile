FROM php:8.4.1-fpm-alpine3.21

RUN apk add --no-cache $PHPIZE_DEPS linux-headers\
    && pecl install xdebug-3.4.0\
    && docker-php-ext-enable xdebug \
    && apk del $PHPIZE_DEPS


# Copy the application public
COPY . /app

VOLUME ["/app"]
