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

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

## Login admin default

Sesudah `php artisan db:seed`, akun admin default:

- `email`: `admin@hotline.local`
- `password`: `password123`

Kredensial ini bisa diubah lewat `.env`:

- `ADMIN_NAME`
- `ADMIN_EMAIL`
- `ADMIN_PASSWORD`

## Konfigurasi penting

Lihat file `.env.example` untuk semua key yang dibutuhkan.

Yang wajib diisi untuk koneksi WhatsApp Cloud API:

- `WHATSAPP_BUSINESS_PHONE`
- `WHATSAPP_PHONE_NUMBER_ID`
- `WHATSAPP_ACCESS_TOKEN`
- `WHATSAPP_WEBHOOK_VERIFY_TOKEN`

## Dokumentasi modul

Dokumentasi implementasi teknis ada di `docs/hotline-module.md`.
