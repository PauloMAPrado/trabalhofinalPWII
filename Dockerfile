# Dockerfile

FROM php:8.2-apache

# Instala dependências do sistema e as extensões PHP
RUN apt-get update && apt-get install -y libicu-dev \
    && docker-php-ext-install intl mysqli pdo_mysql

# Ativa o mod_rewrite
RUN a2enmod rewrite

# Permite .htaccess (muda AllowOverride para All)
RUN sed -i 's/AllowOverride None/AllowOverride All/i' /etc/apache2/apache2.conf