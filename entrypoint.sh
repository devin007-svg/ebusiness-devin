#!/bin/sh
set -e

cd /var/www/html

# Pastikan folder penting ada
mkdir -p storage bootstrap/cache

# ===== SQLite: buat file db sesuai env =====
if [ "$DB_CONNECTION" = "sqlite" ] && [ -n "$DB_DATABASE" ]; then
  DB_DIR="$(dirname "$DB_DATABASE")"
  mkdir -p "$DB_DIR"
  if [ ! -f "$DB_DATABASE" ]; then
    echo "Creating SQLite database at $DB_DATABASE"
    touch "$DB_DATABASE"
  fi
fi

# Permission (storage & cache harus writable)
chown -R www-data:www-data /var/www/html || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

# Cache clear biar env kebaca
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

# Migrate & seed (kalau seed ada)
php artisan migrate --force
php artisan db:seed --force || true

php artisan storage:link || true

exec apache2-foreground
