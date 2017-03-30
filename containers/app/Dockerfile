
FROM debian:jessie

LABEL name="Symfony2 PHP-fpm container"
LABEL version="0.1"

# PHP env var
ENV DEBUG false
# Symfony env var
ENV TAG 3.2
ENV REPO https://github.com/symfony/symfony-standard.git

# install mandatory php packages
RUN apt-get update && apt-get upgrade -y && apt-get install -y git curl php7.1-cli php7.1-mcrypt php7.1-apcu php7.1-gd php7.1-imagick php7.1-curl php7.1-intl php7.1-pgsql

# sync user and group ids with other containers
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data
