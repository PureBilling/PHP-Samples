FROM php:5.6-apache

RUN apt-get update
RUN apt-get install -y git zlib1g-dev libicu-dev build-essential
RUN docker-php-ext-install zip intl