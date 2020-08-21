FROM php:7.4-apache
#Install git
RUN apt-get update && apt-get install -y git
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite
#Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=. --filename=composer
RUN mv composer /usr/local/bin/
#Extensions
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
#Mount src
ADD . / /var/www/html/
EXPOSE 80
