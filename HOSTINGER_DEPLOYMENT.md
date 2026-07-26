# Panduan Deployment Laravel ke Hostinger hPanel via Git

Dokumen ini menjelaskan langkah-langkah lengkap untuk men-deploy aplikasi Laravel **hotline-academic** ke hosting Hostinger menggunakan fitur **Git Deployment** bawaan hPanel.

---

## 1. Persiapan Awal di Komputer Lokal

Sebelum melakukan push ke GitHub/GitLab, pastikan Anda telah mengompilasi aset CSS dan JS secara lokal karena shared hosting tidak selalu menyediakan Node.js untuk melakukan build di server.

1. **Jalankan Perintah Build:**
   ```bash
   npm run build
   ```
   *Catatan: Kami telah mengonfigurasi `.gitignore` agar folder `public/build` ikut masuk ke dalam Git, sehingga aset Anda akan terunggah secara otomatis.*

2. **Commit dan Push Perubahan ke Repositori Git Anda:**
   ```bash
   git add .
   # disarankan menambahkan gitignore dan .htaccess yang baru dibuat
   git commit -m "chore: setup files for Hostinger hPanel deployment"
   git push origin main
   ```

---

## 2. Pengaturan di Hostinger hPanel

### A. Ubah Versi PHP (Sangat Disarankan PHP 8.4)
Laravel 13 membutuhkan minimal **PHP 8.3**, namun kami sangat menyarankan Anda untuk memilih **PHP 8.4** di hPanel demi performa terbaik dan dukungan jangka panjang.
1. Masuk ke **hPanel Hostinger**.
2. Buka menu **Website** -> pilih domain Anda -> **Dashboard**.
3. Cari menu **Tingkat Lanjut (Advanced)** -> **Konfigurasi PHP (PHP Configuration)**.
4. Pilih **PHP 8.4** (atau PHP 8.3 jika 8.4 belum tersedia di region Anda).
5. Klik **Perbarui (Update)**.

### B. Konfigurasi Git Deployment di hPanel
1. Di dashboard hPanel, cari menu **Tingkat Lanjut (Advanced)** -> **Git**.
2. Di bagian **Deploy dari Git (Deploy from Git)**:
   - **Repository Address:** Masukkan URL HTTPS repositori Git Anda (contoh: `https://github.com/username/repository.git`).
   - **Branch:** Pilih branch utama Anda (biasanya `main` atau `master`).
   - **Install Directory:** Kosongkan atau pastikan berisi `public_html` jika ingin menaruhnya di root website utama.
3. Klik **Buat (Create)**.
4. Setelah dibuat, Anda akan melihat info repositori Anda di bagian bawah.
5. **Auto Deployment (Opsional & Sangat Direkomendasikan):** 
   - Salin **Webhook URL** yang disediakan oleh Hostinger di halaman Git tersebut.
   - Buka repositori Anda di GitHub -> **Settings** -> **Webhooks** -> **Add webhook**.
   - Tempel Webhook URL tersebut, set Content type ke `application/json`, lalu klik **Add webhook**. Setiap kali Anda melakukan `git push`, Hostinger secara otomatis akan menarik (pull) kode terbaru Anda.

---

## 3. Konfigurasi Database & File `.env`

1. **Buat Database Baru:**
   - Di hPanel, masuk ke menu **Database** -> **Database MySQL**.
   - Buat database baru, username baru, dan password baru. Catat informasi ini.

2. **Buat File `.env` di Hostinger:**
   - Buka **Pengelola File (File Manager)** di hPanel.
   - Buka folder `public_html`.
   - Buat file baru bernama `.env`.
   - Salin konten dari file `.env.example` lokal Anda ke file `.env` di Hostinger tersebut.
   - Sesuaikan konfigurasi berikut pada `.env` Hostinger Anda:
     ```env
     APP_NAME="Hotline Academic"
     APP_ENV=production
     APP_DEBUG=false
     APP_URL=https://domain-anda.com

     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=nama_database_anda
     DB_USERNAME=username_database_anda
     DB_PASSWORD=password_database_anda
     ```
   - Generate application key: Jika Anda memiliki akses SSH (lihat bagian di bawah), Anda bisa menjalankan `php artisan key:generate`. Jika tidak, Anda dapat menyalin nilai `APP_KEY` dari file `.env` lokal Anda ke file `.env` produksi (namun pastikan tidak bocor).

---

## 4. Menjalankan Composer dan Migrasi Database

Saat pertama kali dideploy, folder `vendor` tidak ikut diunggah karena diabaikan oleh Git. Anda perlu menjalankan `composer install` dan migrasi database. Ada dua metode utama untuk melakukannya:

### Alternatif A: Menggunakan SSH (Rekomendasi & Paling Cepat)
Jika paket hosting Anda mendukung SSH:
1. Di hPanel, aktifkan **Akses SSH** pada menu **Tingkat Lanjut** -> **SSH**.
2. Hubungkan ke server menggunakan terminal/PuTTY dengan kredensial yang disediakan.
3. Masuk ke direktori proyek Anda:
   ```bash
   cd domains/domain-anda.com/public_html
   # atau jika langsung di public_html:
   cd public_html
   ```
4. Jalankan instalasi composer (tanpa paket development untuk performa maksimal):
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
5. Generate Key (jika belum ada):
   ```bash
   php artisan key:generate
   ```
6. Jalankan migrasi database:
   ```bash
   php artisan migrate --force
   ```
7. Optimalkan performa Laravel di produksi:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

### Alternatif B: Menggunakan Cron Jobs hPanel (Jika Tidak Punya SSH)
Jika paket hosting Anda tidak mendukung SSH atau terminal, Anda bisa memanfaatkan fitur **Cron Jobs** di hPanel untuk menjalankan perintah sekali saja:
1. Di hPanel, buka menu **Tingkat Lanjut** -> **Cron Jobs**.
2. Buat Cron Job baru dengan tipe **Custom**.
3. Di kolom **Perintah (Command)**, ketik:
   ```bash
   cd /home/uXXXXXX/domains/domain-anda.com/public_html && composer install --no-dev --optimize-autoloader && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache
   ```
   *(Ganti `uXXXXXX` dengan username hosting Anda, dan `domain-anda.com` dengan nama domain Anda. Anda bisa melihat path lengkap hosting Anda di halaman utama dashboard hPanel).*
4. Atur jadwal eksekusi ke **Sekali per menit** (Common settings: `* * * * *`).
5. Klik **Simpan (Save)**.
6. Tunggu sekitar 1–2 menit agar Cron Job berjalan sekali.
7. **PENTING:** Setelah perintah berhasil dieksekusi (Anda bisa melihat web Anda sudah berjalan), segera **Hapus atau Nonaktifkan** Cron Job tersebut agar tidak terus berjalan setiap menit.

---

## 5. Tips Keamanan & Struktur Folder

### Opsi 1: Mengubah Document Root di hPanel (Sangat Direkomendasikan)
Secara default, domain Anda mengarah langsung ke `public_html`. Agar lebih aman, Anda disarankan mengubah direktori domain Anda agar mengarah ke `public_html/public`.
1. Di hPanel, masuk ke menu **Domain** atau **Web Server Settings** (tergantung tema hPanel).
2. Cari konfigurasi **Document Root** atau **Directory** untuk domain/subdomain Anda.
3. Ubah nilainya dari `public_html` menjadi `public_html/public`.
4. Simpan.

### Opsi 2: Menggunakan `.htaccess` Failsafe (Sudah Disediakan)
Jika hPanel Anda tidak mengizinkan pengubahan Document Root, kami telah membuat file `.htaccess` di root proyek. File ini secara otomatis akan:
- Mengarahkan semua request secara internal dari root (`public_html/`) ke folder `public/`.
- Memblokir akses langsung dari luar ke file sensitif seperti `.env`, `composer.json`, `package.json`, dll., sehingga aman dari eksploitasi peretas.
