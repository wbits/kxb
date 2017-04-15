FROM php:fpm
RUN docker-php-ext-enable opcache
RUN buildDeps="libpq-dev libzip-dev libicu-dev" && \
    apt-get update && \
    apt-get install -y $buildDeps --no-install-recommends && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \
        sockets \
        intl
CMD ["php-fpm"]
