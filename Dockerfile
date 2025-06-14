# Use uma imagem base do PHP com Apache
FROM php:7.4-apache

# Instale as extensões necessárias do PHP   .... nao usar get
RUN apt-get update && apt-get install -y \ 
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j $(nproc) gd mysqli pdo pdo_mysql

    # pesquisar pq das extensões, é necessário?

# Habilite o módulo rewrite do Apache
RUN a2enmod rewrite

# Defina o diretório de trabalho dentro do container
WORKDIR /var/www/html

# Copie os arquivos do projeto para o diretório de trabalho
COPY . /var/www/html/

# Ajuste as permissões (se necessário)
RUN chown -R www-data:www-data /var/www/html/