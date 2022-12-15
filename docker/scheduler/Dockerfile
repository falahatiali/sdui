FROM php:8.1-fpm-alpine

WORKDIR /var/www/html

#RUN docker-php-ext-install sqlite3
RUN apk update && apk upgrade

RUN apk add --no-cache sqlite

COPY crond /etc/crontabs/root

CMD ["crond" , "-f"]
