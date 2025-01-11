FROM php:apache

RUN docker-php-ext-install pdo pdo_mysql && \
    useradd development-server && \
    chown -R development-server /var/www

USER development-server