FROM php:8.2-fpm

RUN apt-get update && apt-get install -qqy git unzip libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        cron \
        supervisor \
        vim \
        sqlite3 \
        libsqlite3-dev \
        procps \
        libaio1 wget && apt-get clean autoclean && apt-get autoremove --yes &&  rm -rf /var/lib/{apt,dpkg,cache,log}/

#composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && \
    apt-get install -y libxml2-dev \
       && docker-php-ext-install \
               soap


CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
