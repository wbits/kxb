FROM nginx:latest

ENV VHOST "kochxbos.dev"

# copy site conf file
COPY silex.conf /etc/nginx/conf.d/
# set the vhost name
RUN sed -r -i.bak "s|(^.*server_name).*$|\1 $VHOST;|" /etc/nginx/conf.d/silex.conf

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

CMD ["nginx", "-g", "daemon off;"]
