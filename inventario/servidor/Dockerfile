# Usa la imagen base de PHP con Apache
FROM php:8.4-apache

# Instala las extensiones de PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libonig-dev libxml2-dev \
    && docker-php-ext-install mbstring mysqli pdo_mysql xml

# Crea el directorio de trabajo y copia el proyecto
WORKDIR /var/www/html
COPY . /var/www/html

# Copia el archivo de configuración de Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Habilita el módulo de reescritura de URL de Apache
RUN a2enmod rewrite

# Configura las exposiciones de puertos
EXPOSE 80
EXPOSE 443