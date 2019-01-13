FROM php:7.2-fpm
# Instal Dependencies
RUN apt-get update && apt-get install -y \
    curl \
    git \
    zip \
    unzip \
    mongodb

# Install OpenSSL PHP Library
RUN apt-get install -y autoconf g++ make openssl \
    libssl-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libsasl2-dev \
    libpcre3-dev




# Install Packages
RUN pecl install xdebug
RUN pecl install mongodb
RUN docker-php-ext-enable xdebug
RUN docker-php-ext-enable mongodb;
#RUN composer require mongodb/mongodb

#COPY mysql/my.cnf /etc/mysql/my.cnf
#RUN sudo apt-get install -y openssl-devel
#RUN sudo apt-get install pecl
#RUN sudo apt-get install gcc
#RUN sudo apt-get install mongodb

## Install Composer
RUN apt-get update && apt-get install sudo -y
RUN sudo curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN export COMPOSER_ALLOW_SUPERUSER=1



#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
## Run Composer Version
#RUN composer --version
#RUN export COMPOSER_ALLOW_SUPERUSER=1