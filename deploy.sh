#!/usr/bin/env bash
echo 'composer install'
composer install

echo 'sudo supervisorctl reload'
sudo supervisorctl reload

sudo chown -R web:web storage
sudo chown -R www-data:www-data storage

echo 'chmod -R ug+rwx storage bootstrap/cache'
chmod -R ug+rwx storage bootstrap/cache

php artisan route:cache
