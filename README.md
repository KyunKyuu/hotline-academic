# Hotline Academic Laravel

Project ini adalah fondasi `Laravel` untuk:

- landing page CTA ke `WhatsApp`
- chatbot hotline akademik berbasis `WhatsApp Cloud API`
- analytics klik CTA dan chat masuk
- dashboard admin untuk grouping `A/B`, filter kampus, dan follow-up

## Fitur yang sudah dibuat

- `GET /` landing page CTA WhatsApp
- `GET /go/whatsapp` track klik CTA lalu redirect ke `wa.me`
- `GET /api/webhooks/whatsapp` verifikasi webhook Meta
- `POST /api/webhooks/whatsapp` proses pesan masuk WhatsApp
- flow chatbot:
  - salam pembuka
  - minta biodata template
  - fallback pertanyaan satu per satu jika parsing tidak lengkap
  - referral opsional
  - grouping `A` jika ada referral, `B` jika tidak ada
  - handover ke admin
- dashboard:
  - summary analytics
  - daftar kontak hotline
  - detail chat dan event
  - update status follow-up admin

## Menjalankan project

Database SQLite (`database/database.sqlite`) sudah disertakan di repo dan sudah berisi hasil migrasi + seed, jadi tidak perlu jalankan `migrate`/`db:seed` untuk mulai development.

```bash
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan serve
```

Kalau ingin reset data ke kondisi awal (misalnya setelah bereksperimen), jalankan:

```bash
php artisan migrate:fresh --seed
```

## Login admin default

Sesudah `php artisan db:seed`, akun admin default:

- `email`: `admin@hotline.local`
- `password`: `password123`

Kredensial ini bisa diubah lewat `.env`:

- `ADMIN_NAME`
- `ADMIN_EMAIL`
- `ADMIN_PASSWORD`

Account ini juga otomatis diberi flag `is_admin = true`, jadi route dashboard hanya bisa diakses akun admin.

## Konfigurasi penting

Lihat file `.env.example` untuk semua key yang dibutuhkan.

Yang wajib diisi untuk koneksi WhatsApp Cloud API:

- `WHATSAPP_BUSINESS_PHONE`
- `WHATSAPP_PHONE_NUMBER_ID`
- `WHATSAPP_ACCESS_TOKEN`
- `WHATSAPP_WEBHOOK_VERIFY_TOKEN`

## Dokumentasi modul

- Dokumentasi implementasi teknis: `docs/hotline-module.md`
- Panduan pengujian dan hosting: `docs/panduan-pengujian-hosting.md`
- Checklist deploy dan setup webhook Meta: `docs/meta-webhook-deploy-checklist.md`
