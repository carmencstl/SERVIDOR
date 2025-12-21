FROM php:8.4-apache

# 1. Instalaciones básicas
RUN apt-get update && apt-get install -y zip unzip

# 2. Extensiones de base de datos
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

# 3. Habilitar mod_rewrite (solo una vez)
RUN a2enmod rewrite

# 4. CONFIGURACIÓN PARA MÚLTIPLES PROYECTOS
# Mantenemos el DocumentRoot por defecto (/var/www/html)
# pero permitimos que cada subcarpeta use su propio .htaccess
RUN echo '<Directory "/var/www/html">\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Reiniciar Apache para asegurar cambios
RUN service apache2 restart || true