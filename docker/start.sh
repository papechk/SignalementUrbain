#!/bin/bash
set -e

PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen $PORT/" /etc/apache2/ports.conf
sed -i "s/:80/:$PORT/" /etc/apache2/sites-available/000-default.conf

touch /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database/database.sqlite

cd /var/www/html

for i in 1 2 3; do
    php artisan migrate --force && break
    echo "Migration attempt $i failed, retrying..."
    sleep 3
done

for i in 1 2 3; do
    php artisan db:seed --force && break
    echo "Seed attempt $i failed, retrying..."
    sleep 3
done

chown -R www-data:www-data storage bootstrap/cache database

exec apache2-foreground
