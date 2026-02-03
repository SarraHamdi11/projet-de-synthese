#!/bin/sh
cd /app/hob
php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=8000
