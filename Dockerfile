FROM php:8.3.4-apache
RUN docker-php-ext-install mysqli
EXPOSE 80