#!/bin/sh

# 1. Instalar dependencias de PHP con Composer
if [ -f "composer.json" ]; then
    echo "Instalando dependencias de Composer..."
    composer install --no-interaction --optimize-autoloader
fi

# 2. Instalar dependencias de JavaScript y compilar assets (Vite / Mix)
if [ -f "package.json" ]; then
    echo "Instalando dependencias de Node.js..."
    npm install
    
    echo "Compilando assets con Vite/Mix..."
    npm run build
fi

# 3. Generar APP_KEY si no existe en el archivo .env
if [ -f ".env" ] && ! grep -q "APP_KEY=base64:" .env; then
    echo "Generando clave de la aplicación Laravel..."
    php artisan key:generate
fi

# 4. Asegurar la creación de directorios requeridos por Laravel
mkdir -p /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache/data \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

# 5. Ajustar permisos para Apache (www-data)
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 6. Esperar a que la base de datos MariaDB esté lista
echo "Esperando conexión a la base de datos..."
while ! nc -z mariadb 3306; do
  sleep 1
done
echo "Base de datos disponible."

# 7. Crear enlace simbólico de almacenamiento si no existe
php artisan storage:link --quiet

# 8. Ejecutar migraciones de la base de datos
php artisan migrate --force

# 9. Iniciar Apache
exec "$@"