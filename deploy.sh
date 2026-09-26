#!/usr/bin/env bash
#
# Run on the server after new code is pulled from GitHub:
#   bash deploy.sh
#
# Installs PHP packages, updates the database and refreshes caches.
# The CSS/JS in public/build is built before each release and committed,
# so the server doesn't need Node.js.

set -e
cd "$(dirname "$0")"

echo "→ Installing PHP packages"
composer install --no-dev --optimize-autoloader --no-interaction

echo "→ Putting the site in maintenance mode"
php artisan down --retry=15 || true

echo "→ Updating the database"
php artisan migrate --force

echo "→ Linking uploaded files folder"
php artisan storage:link 2>/dev/null || true

echo "→ Refreshing caches"
php artisan optimize:clear
php artisan optimize
php artisan filament:optimize 2>/dev/null || true

echo "→ Back online"
php artisan up

echo "✓ Deploy finished"
