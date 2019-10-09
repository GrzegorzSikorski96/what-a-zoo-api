FROM php:7.3-fpm-alpine

WORKDIR "/application"

RUN apk --no-cache add \
    bash \
    git \
    && docker-php-ext-install \
    pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

ARG INSTALL_XDEBUG=false
ARG XDEBUG_HOST=127.0.0.1
ARG XDEBUG_PORT=9000
ARG XDEBUG_AUTOSTART=1

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    apk --no-cache add $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_host=${XDEBUG_HOST}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=${XDEBUG_PORT}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=${XDEBUG_AUTOSTART}" >> /usr/local/etc/php/conf.d/xdebug.ini \
;fi

