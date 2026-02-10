#!/bin/sh
set -e

cd /var/www/html

# =========================
# Railway PORT fix (WAJIB)
# =========================
# Railway biasanya set env PORT (bukan selalu 80). Apache harus listen di port itu.
PORT="${PORT:-80}"

# Update Apache listen port
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf

# Update VirtualHost port (default site)
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Kadang ada juga config enabled yang hardcode :80 (amanin aja)
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-enabled/000-default.conf 2>/dev/null || true


# =========================
# Pastikan folder penting ada
# =========================
mkdir -p storage bootstrap/cache


# =========================
# SQLite: buat file db sesuai env
# =========================
# ENV di Railway:
# DB_CONNECTION=sqlite
# DB_DATABASE=/data/database.sqlite
if [ "$DB_CONNECTION" = "sqlite" ] && [ -n "$DB_DATABASE" ]; then
  DB_DIR="$(dirname "$DB_DATABASE")"
  mkdir -p "$DB_DIR"
  if [ ! -f "$DB_DATABASE" ]; then
    echo "Creating SQLite database at $DB_DATABASE"
    touch "$DB_DATABASE"
  fi
fi


# =========================
# Permission (storage & cache harus writable)
# =========================
chown -R www-data:www-data /var/www/html || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true


# =========================
# Clear cache biar env kebaca
# =========================
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true


# =========================
# Migrate & seed
# =========================
# Kalau migrate gagal, container akan exit (karena set -e). Itu bagus untuk production.
# Kalau kamu mau lebih "tahan banting" untuk debug, ganti migrate jadi "|| true".
php artisan migrate --force

# Seed dibuat aman biar app tetap bisa jalan walau seeder error
php artisan db:seed --force || true


# =========================
# Storage symlink untuk public/storage
# =========================
php artisan storage:link || true


# =========================
# Start Apache (foreground)
# =========================
exec apache2-foreground
