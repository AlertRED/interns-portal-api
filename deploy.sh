#!/usr/bin/env bash
echo 'composer install'
composer install

echo 'sudo supervisorctl reload'
sudo supervisorctl reload

sudo chown -R web:web storage
sudo chown -R www-data:www-data storage

php artisan route:cache
