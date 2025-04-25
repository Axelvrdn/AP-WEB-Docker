FROM php:8.2-apache

# Installer les extensions nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activer mod_rewrite
RUN a2enmod rewrite

# Autoriser l'utilisation de .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copier le script d'entrée
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Copier le code (sera écrasé par le volume, mais utile pour build pur)
COPY . /var/www/html/

# Entrypoint
ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 80
