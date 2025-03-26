#!/bin/sh

# Wait for MySQL to be ready
echo "Waiting for MySQL..."
until nc -z -v -w30 db 3306; do
  echo "MySQL is not ready yet. Waiting..."
  sleep 5
done
echo "MySQL is up - running migrations"

php artisan queue:table

# Run migrations
php artisan migrate --force

# Start Laravel development server
php artisan serve --host=0.0.0.0 --port=8000
