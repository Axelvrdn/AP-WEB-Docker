# Utiliser une image PHP avec Apache
FROM php:8.2-apache

# Installer les extensions nécessaires (ex: mysqli pour MySQL)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copier le code du projet dans le conteneur
COPY . /var/www/html/

# Donner les bons droits
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80 pour accéder au site
EXPOSE 80