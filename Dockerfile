FROM php:8.3.4-apache

# Instalar extensões do PHP
RUN docker-php-ext-install mysqli

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar o projeto Yii para o container
COPY ./basic /var/www/html

EXPOSE 80
