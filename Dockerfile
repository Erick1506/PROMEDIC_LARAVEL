FROM php:8.2-apache

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    zip \
    curl \
    git \
    libpng-dev \
    libxml2-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd xml

# Habilita mod_rewrite de Apache
RUN a2enmod rewrite

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece directorio de trabajo
WORKDIR /var/www/html

# Copia el proyecto
COPY . /var/www/html

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expone el puerto 80
EXPOSE 80

CMD ["apache2-foreground"]