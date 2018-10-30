#!/usr/bin/env bash
echo 'composer install'
composer install

echo 'php artisan migrate'
php artisan migrate

# Сиды только если универсальные
echo 'php artisan db:seed'
php artisan db:seed

# натройка прав на файлы и папки laravel (production)
echo 'find ./ -type d -exec chmod 755 {} \;'
find ./ -type d -exec chmod 755 {} \;
echo 'find ./ -type f -exec chmod 644 {} \;'
find ./ -type f -exec chmod 644 {} \;

echo 'chown -R www-data:www-data ./'
chown -R www-data:www-data ./

echo 'chgrp -R www-data storage bootstrap/cache'
chgrp -R www-data storage bootstrap/cache
echo 'chmod -R ug+rwx storage bootstrap/cache'
chmod -R ug+rwx storage bootstrap/cache

echo 'sudo supervisorctl reload'
sudo supervisorctl reload

php artisan route:cache
