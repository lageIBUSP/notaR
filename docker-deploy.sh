#!/bin/sh

# Installs and upgrades any new PHP libraries
if [ "$APP_ENV" == "production" ]; then
  composer install --no-dev -o
else
  composer install
fi
# Makes sure our storage link is set up
php artisan storage:link
# Runs any DB migration
php artisan migrate --force
# Clear and restart caches
php artisan cache:clear
php artisan config:cache
php artisan view:cache
php artisan route:cache
php artisan event:cache
