#!/bin/sh

# Installs and upgrades any new PHP libraries
if [ "$APP_ENV" == "production" ]; then
  composer install --no-dev -o
else
  composer install
fi
# Makes sure our storage link is set up
php artisan storage:link
# Clear application and config caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
# Runs any DB migration
php artisan migrate --force
# Setup caches
php artisan config:cache
php artisan view:cache
