FROM php:8.2-apache


# Instala PDO + cliente MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql && \
    apt-get update && apt-get install -y default-mysql-client && docker-php-ext-enable mysqli

RUN echo "ServerName webserver" >> /etc/apache2/apache2.conf

# Habilita mod_rewrite do Apache
RUN a2enmod rewrite

# Define diretório padrão
WORKDIR /var/www/html