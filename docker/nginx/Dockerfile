FROM nginx:1.21-alpine

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www/api
USER nginx
EXPOSE 80