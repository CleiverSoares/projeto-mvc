#!/bin/bash
composer install --no-interaction --prefer-dist --optimize-autoloader
php artisan config:clear
php artisan view:clear
php artisan route:clear

