#!/usr/bin/env bash
mkdir -p database
touch database/database.sqlite
php artisan config:cache
php artisan migrate --force