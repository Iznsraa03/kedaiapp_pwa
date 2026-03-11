# 🚀 Panduan Deploy ke VPS Biznet Geo

## Spesifikasi yang Dibutuhkan

| Komponen | Rekomendasi |
|---|---|
| OS | Ubuntu 22.04 LTS |
| RAM | Minimal 1 GB (2 GB recommended) |
| PHP | 8.2 atau lebih tinggi |
| Database | MySQL 8.0 / MariaDB 10.6 |
| Web Server | Nginx |
| Node.js | 18 LTS atau lebih tinggi |

---

## 1. Persiapan Awal — Akses VPS

Setelah mendapatkan IP, username, dan password dari Biznet Geo:

```bash
ssh root@YOUR_VPS_IP
```

Update sistem terlebih dahulu:

```bash
apt update && apt upgrade -y
```

---

## 2. Install PHP 8.2 dan Ekstensi yang Dibutuhkan

```bash
apt install -y software-properties-common
add-apt-repository ppa:ondrej/php -y
apt update

apt install -y php8.2 php8.2-fpm php8.2-cli php8.2-mysql php8.2-mbstring \
  php8.2-xml php8.2-curl php8.2-zip php8.2-bcmath php8.2-gd \
  php8.2-intl php8.2-tokenizer php8.2-ctype php8.2-fileinfo
```

Verifikasi:

```bash
php -v
```

---

## 3. Install Nginx

```bash
apt install -y nginx
systemctl enable nginx
systemctl start nginx
```

---

## 4. Install MySQL

```bash
apt install -y mysql-server
systemctl enable mysql
systemctl start mysql

# Amankan MySQL
mysql_secure_installation
```

Buat database dan user:

```bash
mysql -u root -p
```

```sql
CREATE DATABASE nama_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'nama_user'@'localhost' IDENTIFIED BY 'password_kuat';
GRANT ALL PRIVILEGES ON nama_database.* TO 'nama_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

## 5. Install Composer

```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer
composer -V
```

---

## 6. Install Node.js & npm

```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
apt install -y nodejs
node -v && npm -v
```

---

## 7. Upload / Clone Aplikasi

**Opsi A — Menggunakan Git (recommended):**

```bash
cd /var/www
git clone https://github.com/username/repo-name.git namaapp
cd namaapp
```

**Opsi B — Upload via SFTP/SCP:**

Gunakan tools seperti FileZilla, WinSCP, atau rsync:

```bash
rsync -avz ./project/ root@YOUR_VPS_IP:/var/www/namaapp/
```

---

## 8. Setup Aplikasi Laravel

Masuk ke folder aplikasi:

```bash
cd /var/www/namaapp
```

Install dependencies PHP:

```bash
composer install --optimize-autoloader --no-dev
```

Install & build frontend assets:

```bash
npm install
npm run build
```

Copy dan edit file environment:

```bash
cp .env.example .env
nano .env
```

Isi nilai penting di `.env`:

```env
APP_NAME="Nama Aplikasi"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=nama_user
DB_PASSWORD=password_kuat

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

Generate application key:

```bash
php artisan key:generate
```

Jalankan migrasi database:

```bash
php artisan migrate --force
```

Jalankan seeder (jika diperlukan):

```bash
php artisan db:seed --force
```

Optimize aplikasi untuk production:

```bash
php artisan optimize
php artisan view:cache
php artisan route:cache
php artisan config:cache
```

---

## 9. Atur Permission File

```bash
chown -R www-data:www-data /var/www/namaapp
chmod -R 755 /var/www/namaapp
chmod -R 775 /var/www/namaapp/storage
chmod -R 775 /var/www/namaapp/bootstrap/cache
```

---

## 10. Konfigurasi Nginx

Buat file konfigurasi Nginx:

```bash
nano /etc/nginx/sites-available/namaapp
```

Isi dengan konfigurasi berikut:

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/namaapp/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Aktifkan konfigurasi dan restart Nginx:

```bash
ln -s /etc/nginx/sites-available/namaapp /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```

---

## 11. Setup SSL dengan Let's Encrypt (HTTPS)

```bash
apt install -y certbot python3-certbot-nginx
certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

Ikuti instruksi yang muncul. Certbot akan otomatis memperbarui konfigurasi Nginx untuk HTTPS.

---

## 12. Setup Queue Worker (Opsional tapi Recommended)

Karena aplikasi ini menggunakan `QUEUE_CONNECTION=database`, buat systemd service agar queue worker berjalan terus:

```bash
nano /etc/systemd/system/namaapp-queue.service
```

```ini
[Unit]
Description=Laravel Queue Worker - namaapp
After=network.target

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/namaapp/artisan queue:work --sleep=3 --tries=3 --max-time=3600

[Install]
WantedBy=multi-user.target
```

```bash
systemctl enable namaapp-queue
systemctl start namaapp-queue
systemctl status namaapp-queue
```

---

## 13. Setup Firewall (UFW)

```bash
ufw allow OpenSSH
ufw allow 'Nginx Full'
ufw enable
ufw status
```

---

## ✅ Checklist Akhir

- [ ] PHP 8.2 terinstall dengan semua ekstensi
- [ ] MySQL berjalan dan database sudah dibuat
- [ ] Composer dependencies terinstall
- [ ] `npm run build` berhasil (assets terbuild)
- [ ] File `.env` sudah dikonfigurasi
- [ ] `APP_KEY` sudah di-generate
- [ ] Migrasi database sudah dijalankan
- [ ] Permission folder `storage` dan `bootstrap/cache` benar
- [ ] Nginx konfigurasi sudah aktif
- [ ] SSL (HTTPS) sudah terpasang
- [ ] Queue worker berjalan (jika diperlukan)
- [ ] Firewall aktif

---

## 🔄 Proses Update Aplikasi (Kedepannya)

Setiap kali ada update kode, jalankan:

```bash
cd /var/www/namaapp
git pull origin main
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan migrate --force
php artisan optimize
systemctl restart namaapp-queue
```
