FROM php:8.0-apache

RUN apt-get update && apt-get install -y

RUN docker-php-ext-install mysqli pdo_mysql

# RUN mkdir /app/

# COPY src/ /app/

# RUN cp -r /app/* /var/www/html/.

#  sudo docker exec -it IMAGE_NAME bash