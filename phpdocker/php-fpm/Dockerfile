FROM phpdockerio/php:8.3-fpm
WORKDIR "/application"

# TODO - segment Dockerfiles for different environments. E.g. xdebug not required on production
RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        php8.3-memcached \ 
        php8.3-mysql \
        php8.3-xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


# [install composer and install dependencies](https://www.youtube.com/watch?v=qv-P_rPFw4c)
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer
COPY composer.* .
RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction
COPY . .
RUN composer dump-autoload --optimize