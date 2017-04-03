FROM debian:jessie

# install mandatory php packages
RUN apt-get update && apt-get upgrade -y && apt-get install -y git curl wget
RUN echo "deb http://packages.dotdeb.org jessie all" | tee -a /etc/apt/sources.list.d/dotdeb.list
RUN echo "deb-src http://packages.dotdeb.org jessie all" | tee -a /etc/apt/sources.list.d/dotdeb.list
RUN wget -qO - http://www.dotdeb.org/dotdeb.gpg | apt-key add -
RUN apt-get update
RUN apt-get install php7.0-cli php7.0-curl php7.0-dev php7.0-zip php7.0-fpm php7.0-gd php7.0-xml php7.0-mysql php7.0-mcrypt php7.0-mbstring php7.0-opcache -y

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

#### start container
CMD ["php-fpm"]
EXPOSE 9000
