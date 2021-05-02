#!/bin/sh

# Installs and upgrades any new PHP libraries
composer install
# Makes sure our storage link is set up
php artisan storage:link
# Clear application and config caches
php artisan config:clear
php artisan cache:clear
# Runs any DB migration
php artisan migrate --force
