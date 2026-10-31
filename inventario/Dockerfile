# Copy Composer and Node.js from official images.
FROM composer:2 AS composer_bin

FROM node:20-slim AS node_bin

FROM php:8.4-apache

COPY --from=composer_bin /usr/bin/composer /usr/bin/composer
COPY --from=node_bin /usr/local/bin/node /usr/local/bin/node
COPY --from=node_bin /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/bin/node /usr/local/bin/nodejs \
    && ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

# Install system libraries and PHP extensions required by Laravel.
RUN apt-get update && apt-get install -y \
    libonig-dev libxml2-dev unzip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring pdo_mysql xml zip bcmath \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Dependencies and production assets are built into the image, not installed
# or regenerated every time the container starts.
COPY . /var/www/html
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts \
    && php artisan package:discover --ansi \
    && npm ci --no-audit --no-fund \
    && npm run build \
    && rm -rf node_modules \
    && mkdir -p storage/framework/views storage/framework/cache/data storage/framework/sessions storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN a2enmod rewrite

# Copiar el script de entrada y asignar permisos
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80 443

ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]
