#!/bin/bash

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
# Clear caches
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan event:clear
# Cache views and events only on production
if [ "$APP_ENV" == "production" ]; then
  php artisan view:cache
  php artisan event:cache
fi
