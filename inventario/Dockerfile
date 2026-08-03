# 1. Copiar Composer desde la imagen oficial
FROM composer:latest AS composer_bin

# 2. Copiar Node.js/npm desde la imagen oficial
FROM node:20-slim AS node_bin

# 3. Imagen base principal: PHP 8.4 con Apache
FROM php:8.4-apache

# Traer ejecutables de Composer y Node.js/npm
COPY --from=composer_bin /usr/bin/composer /usr/bin/composer
COPY --from=node_bin /usr/local/bin/node /usr/local/bin/node
COPY --from=node_bin /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/bin/node /usr/local/bin/nodejs \
    && ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

# Instalar dependencias del sistema y extensiones necesarias (AÑADIDO bcmath AQUÍ)
RUN apt-get update && apt-get install -y \
    libonig-dev libxml2-dev unzip git libpng-dev libjpeg-dev libfreetype6-dev libzip-dev netcat-openbsd \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring mysqli pdo_mysql xml zip bcmath

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar el proyecto al contenedor
COPY . /var/www/html

# Habilitar el módulo rewrite de Apache
RUN a2enmod rewrite

# Copiar el script de entrada y asignar permisos
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80 443

ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]