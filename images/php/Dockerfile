FROM php:8.0-apache

ARG CONTAINER_USER
ARG CONTAINER_USER_ID
ARG CONTAINER_USER_PW=docker

RUN useradd -m ${CONTAINER_USER} --uid=${CONTAINER_USER_ID} && echo "${CONTAINER_USER}:${CONTAINER_USER_PW}" | chpasswd
RUN usermod -aG sudo,www-data ${CONTAINER_USER}

ENV APACHE_RUN_USER=${CONTAINER_USER}

RUN apt-get update && apt-get install --fix-missing -y \
     libzip-dev libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
     libfreetype6-dev libmagickwand-dev libgmp-dev libldap2-dev git zip

RUN docker-php-ext-configure zip
RUN docker-php-ext-configure gd
RUN docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_mysql exif pcntl bcmath mysqli

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN pecl install swoole
RUN docker-php-ext-enable swoole

RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV PROJECT_PATH=/var/www

COPY default.conf /etc/apache2/sites-enabled/000-default.conf

COPY custom.ini /usr/local/etc/php/conf.d/00-custom.ini

RUN a2enmod rewrite
