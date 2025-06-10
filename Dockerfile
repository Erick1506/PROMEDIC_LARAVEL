# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Instala extensiones requeridas por Laravel
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Habilita mod_rewrite para URLs limpias en Laravel
RUN a2enmod rewrite

# Copia todo el contenido del proyecto al contenedor
COPY . /var/www/html

# Establece permisos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Cambia el directorio de trabajo
WORKDIR /var/www/html

# Configura Apache para servir desde la carpeta public/
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Instala Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Instala dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Cachea configuración
RUN php artisan config:cache

# Expone el puerto 80 (por defecto en Apache)
EXPOSE 80

# Comando para mantener Apache corriendo
CMD ["apache2-foreground"]