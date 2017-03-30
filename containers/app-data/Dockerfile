FROM debian:jessie

# sync user and group ids with other containers
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

# create and mount volume
RUN mkdir -p /var/www /var/www/web && chown -R www-data:www-data /var/www/web
VOLUME /var/www/web
CMD echo "Container for silex code ready"
