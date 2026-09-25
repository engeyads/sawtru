#!/bin/sh
set -e

cd /var/www/html

# Create .env on first run; values from docker-compose environment override it
if [ ! -f .env ]; then
    cp .env.example .env
fi

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

php artisan package:discover --ansi
php artisan config:clear

# Wait until MySQL accepts connections
until php -r 'new PDO("mysql:host=".getenv("DB_HOST").";port=".getenv("DB_PORT"), getenv("DB_USERNAME"), getenv("DB_PASSWORD"));' 2>/dev/null; do
    echo "Waiting for database..."
    sleep 2
done

php artisan migrate --force

# Seed roles, admin and demo users only once (on an empty database)
if [ "$(php artisan tinker --execute='echo \App\Models\User::count();' 2>/dev/null | tail -n 1)" = "0" ]; then
    php artisan db:seed --force
fi

chown -R www-data:www-data storage bootstrap/cache public/uploads

exec "$@"
