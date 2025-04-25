#!/bin/bash

# Fix les droits à chaque démarrage pour éviter les erreurs "Forbidden"
echo "Fixing permissions on /var/www/html..."
chown -R www-data:www-data /var/www/html
find /var/www/html -type d -exec chmod 755 {} \;
find /var/www/html -type f -exec chmod 644 {} \;

# Démarrer Apache en mode foreground
exec apache2-foreground
