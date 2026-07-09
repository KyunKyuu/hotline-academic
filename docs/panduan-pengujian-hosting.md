# Panduan Pengujian dan Hosting Hotline Academic

Dokumen ini berisi langkah praktis untuk mulai menguji aplikasi secara lokal, menguji integrasi WhatsApp webhook, dan menyiapkan hosting production.

## 1. Kebutuhan awal

Pastikan server atau mesin lokal memiliki:

- PHP `8.3` atau lebih baru
- Composer
- Node.js dan npm
- SQLite untuk pengujian lokal, atau MySQL/MariaDB/PostgreSQL untuk hosting
- Ekstensi PHP umum Laravel, termasuk `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, dan `fileinfo`

## 2. Setup lokal pertama kali

Jalankan dari root project:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Jika memakai SQLite lokal, buat file database:

```bash
touch database/database.sqlite
```

Di Windows PowerShell:

```powershell
New-Item -ItemType File -Force database/database.sqlite
```

Pastikan `.env` memakai konfigurasi ini untuk SQLite:

```env
DB_CONNECTION=sqlite
```

Lalu jalankan migrasi dan seeder:

```bash
php artisan migrate
php artisan db:seed
```

Seeder membuat akun admin default:

- Email: `admin@hotline.local`
- Password: `password123`

Untuk development cepat, project juga menyediakan script:

```bash
composer run setup
```

Script ini menjalankan install dependency, membuat `.env` jika belum ada, generate key, migrate, install npm package, dan build asset.

## 3. Menjalankan aplikasi untuk pengujian lokal

Opsi paling lengkap:

```bash
composer run dev
```

Command ini menjalankan:

- server Laravel
- queue listener
- Vite dev server

Jika hanya butuh server Laravel:

```bash
php artisan serve
```

Buka aplikasi:

- Landing page: `http://127.0.0.1:8000`
- Login admin: `http://127.0.0.1:8000/admin/login`
- Dashboard hotline: `http://127.0.0.1:8000/admin/hotline`

## 4. Menjalankan automated test

Jalankan:

```bash
composer run test
```

Atau langsung:

```bash
php artisan test
```

Sebelum test, pastikan dependency sudah terpasang dan `.env` valid. Jika konfigurasi berubah, bersihkan cache:

```bash
php artisan config:clear
```

## 5. Checklist pengujian manual lokal

Gunakan checklist ini sebelum deploy:

1. Buka landing page `/`.
2. Klik tombol WhatsApp.
3. Pastikan diarahkan ke `wa.me`.
4. Pastikan event klik CTA muncul di dashboard admin.
5. Login ke `/admin/login`.
6. Buka `/admin/hotline`.
7. Cek daftar kontak, event analytics, dan detail percakapan.
8. Update status follow-up kontak.
9. Pastikan perubahan status tersimpan.

Jika tombol WhatsApp belum benar, isi env berikut:

```env
WHATSAPP_BUSINESS_PHONE=6281234567890
WHATSAPP_PREFILLED_MESSAGE="Halo, saya ingin bertanya tentang hotline akademik."
WA_TRACK_CTA=true
```

## 6. Menguji webhook WhatsApp lokal

Meta membutuhkan URL publik HTTPS untuk webhook. Untuk pengujian lokal, gunakan tunnel seperti `ngrok`, Cloudflare Tunnel, atau layanan sejenis.

Contoh dengan ngrok:

```bash
php artisan serve
ngrok http 8000
```

Gunakan URL HTTPS dari tunnel sebagai callback:

```text
https://domain-tunnel.example/api/webhooks/whatsapp
```

Isi `.env` lokal:

```env
APP_URL=https://domain-tunnel.example
WHATSAPP_BUSINESS_PHONE=6281234567890
WHATSAPP_API_VERSION=v23.0
WHATSAPP_PHONE_NUMBER_ID=your-phone-number-id
WHATSAPP_BUSINESS_ACCOUNT_ID=your-business-account-id
WHATSAPP_ACCESS_TOKEN=your-access-token
WHATSAPP_WEBHOOK_VERIFY_TOKEN=your-random-verify-token
WA_BOT_ENABLED=true
WA_TRACK_CTA=true
WA_TRACK_INCOMING_MESSAGES=true
```

Setelah env diubah:

```bash
php artisan config:clear
```

Tes verifikasi webhook dari browser:

```text
https://domain-tunnel.example/api/webhooks/whatsapp?hub.mode=subscribe&hub.verify_token=your-random-verify-token&hub.challenge=123456
```

Hasil benar:

- HTTP status `200`
- Body berisi `123456`

## 7. Alur uji chatbot WhatsApp

Setelah webhook tersambung di Meta:

1. Kirim pesan ke nomor WhatsApp Business.
2. Pastikan bot membalas welcome message.
3. Balas biodata dengan format:

```text
Nama: Budi
Semester: 3
Kampus: Kampus A
Jurusan: Sistem Informasi
```

4. Balas referral jika ada, atau `tidak ada`.
5. Pastikan dashboard menampilkan kontak baru.
6. Pastikan group terisi:
   - `A` jika ada referral
   - `B` jika tanpa referral

## 8. Persiapan hosting production

Di server production, arahkan document root web server ke folder:

```text
public
```

Jangan arahkan document root ke root project.

Contoh env production minimum:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://hotline.domainkamu.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotline_academic
DB_USERNAME=hotline_user
DB_PASSWORD=strong-password

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

WHATSAPP_BUSINESS_PHONE=6281234567890
WHATSAPP_API_VERSION=v23.0
WHATSAPP_PHONE_NUMBER_ID=your-phone-number-id
WHATSAPP_BUSINESS_ACCOUNT_ID=your-business-account-id
WHATSAPP_ACCESS_TOKEN=your-permanent-access-token
WHATSAPP_WEBHOOK_VERIFY_TOKEN=your-secure-verify-token

ADMIN_NAME="Hotline Admin"
ADMIN_EMAIL=admin@domainkamu.com
ADMIN_PASSWORD=change-this-password
```

## 9. Deploy ke server

Jalankan di server:

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Jika `.env` production sudah memiliki `APP_KEY`, jangan jalankan `php artisan key:generate` ulang karena session dan data terenkripsi bisa tidak terbaca.

Pastikan folder berikut bisa ditulis oleh user web server:

- `storage`
- `bootstrap/cache`

## 10. Queue worker production

Project memakai `QUEUE_CONNECTION=database` di `.env.example`. Untuk production, jalankan worker:

```bash
php artisan queue:work --tries=3
```

Di server Linux, jalankan worker lewat Supervisor atau systemd agar otomatis restart.

Contoh command yang dijalankan Supervisor:

```bash
php /path/to/project/artisan queue:work --tries=3 --sleep=3
```

## 11. Konfigurasi web server

### Nginx

Gunakan pola umum Laravel:

```nginx
server {
    listen 80;
    server_name hotline.domainkamu.com;
    root /path/to/project/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Aktifkan HTTPS setelah domain mengarah ke server.

### Apache

Pastikan `mod_rewrite` aktif dan `DocumentRoot` mengarah ke:

```text
/path/to/project/public
```

Laravel sudah menyediakan `public/.htaccess` untuk rewrite request.

## 12. Checklist go-live

Sebelum domain dibuka:

1. `APP_ENV=production`.
2. `APP_DEBUG=false`.
3. `APP_URL` memakai domain HTTPS final.
4. Password admin default sudah diganti.
5. Token WhatsApp bukan token sementara.
6. Callback webhook Meta memakai `https://domain/api/webhooks/whatsapp`.
7. Verify token di Meta sama dengan `WHATSAPP_WEBHOOK_VERIFY_TOKEN`.
8. Field webhook `messages` sudah disubscribe.
9. Landing page bisa dibuka.
10. CTA WhatsApp redirect ke nomor benar.
11. Pesan masuk WhatsApp tersimpan di dashboard.
12. Bot bisa membalas pesan.
13. Queue worker aktif jika traffic sudah berjalan.

Detail khusus setup webhook Meta juga tersedia di `docs/meta-webhook-deploy-checklist.md`.
