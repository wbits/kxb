FROM debian:jessie

LABEL name="Silex PHP-fpm container"
LABEL version="0.1"

# install mandatory php packages
RUN apt-get update && apt-get upgrade -y && apt-get install -y git curl
RUN cd /tmp && git clone https://github.com/kasparsd/php-7-debian.git
RUN cd cd php-7-debian/
RUN ./build.sh

# install composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# ini & conf files
COPY conf/silex.ini /etc/php7/fpm/conf.d/
COPY conf/silex.ini /etc/php7/cli/conf.d/
COPY conf/silex.pool.conf /etc/php7/fpm/pool.d/

# sync user and group ids with other containers
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

# copy entrypoint file
COPY ./entrypoint.sh /

RUN chmod +x /entrypoint.sh

# set entry point
ENTRYPOINT [ "/entrypoint.sh" ]

# start container
CMD ["php7.0-fpm", "-F"]
EXPOSE 9000
