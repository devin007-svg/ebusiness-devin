#!/bin/sh
set -e

cd /var/www/html

# =========================
# Railway PORT fix (WAJIB)
# =========================
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-enabled/000-default.conf 2>/dev/null || true

# =========================
# Pastikan folder penting ada
# =========================
mkdir -p storage bootstrap/cache

# =========================
# SQLite: buat file db sesuai env
# =========================
if [ "$DB_CONNECTION" = "sqlite" ] && [ -n "$DB_DATABASE" ]; then
  DB_DIR="$(dirname "$DB_DATABASE")"
  mkdir -p "$DB_DIR"
  if [ ! -f "$DB_DATABASE" ]; then
    echo "Creating SQLite database at $DB_DATABASE"
    touch "$DB_DATABASE"
  fi
fi

# Permission
chown -R www-data:www-data /var/www/html || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

# Clear cache biar env kebaca
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

# Migrate (wajib)
php artisan migrate --force

# Seed (opsional, jangan bikin container mati)
php artisan db:seed --force || true

# Storage link (lebih rapi)
if [ ! -L public/storage ]; then
  php artisan storage:link || true
fi

exec apache2-foreground
