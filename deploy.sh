#!/usr/bin/env bash
echo 'composer install'
composer install

echo 'sudo supervisorctl reload'
sudo supervisorctl reload

php artisan route:cache
