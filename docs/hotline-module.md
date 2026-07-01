# Hotline WhatsApp Module

## Ringkasan

Modul ini menangani:

- tracking klik CTA landing page ke WhatsApp
- penerimaan webhook dari `WhatsApp Cloud API`
- flow chatbot biodata mahasiswa
- grouping `A/B` berdasarkan referral opsional
- handover ke admin dashboard
- analytics dasar hotline

## Arsitektur

### Alur CTA

1. Pengunjung klik tombol website.
2. Route `GET /go/whatsapp` menyimpan event `cta_clicked`.
3. Sistem redirect ke `wa.me/<nomor>?text=<prefilled message>`.

### Alur Chatbot

1. User chat ke nomor bisnis.
2. Meta mengirim event ke `POST /api/webhooks/whatsapp`.
3. `HotlineBotService` menyimpan inbound message.
4. Jika user baru, bot kirim salam dan template biodata.
5. Jika user membalas template:
   - parser mencoba baca `Nama`, `Semester`, `Kampus`, `Jurusan`
6. Jika parser gagal lengkap:
   - bot fallback ke mode guided
   - bot bertanya field per field
7. Setelah biodata lengkap:
   - bot meminta referral opsional
8. Jika referral diisi:
   - `group_type = A`
9. Jika referral kosong:
   - `group_type = B`
10. Bot mengirim pesan bahwa admin akan menghubungi.
11. Dashboard menampilkan data untuk admin follow-up.

## State Chatbot

- `new`
- `awaiting_biodata`
- `awaiting_name`
- `awaiting_semester`
- `awaiting_campus`
- `awaiting_major`
- `awaiting_referral`
- `waiting_admin`
- `closed`

## Tabel Database

### `wa_contacts`

Menyimpan master data user WhatsApp:

- nomor user
- nama profil WA
- biodata akademik
- referral
- group `A/B`
- state chatbot
- timestamp penting

### `wa_conversations`

Menyimpan sesi percakapan user.

### `wa_messages`

Menyimpan semua pesan inbound dan outbound.

### `wa_analytics_events`

Menyimpan event analytics seperti:

- `cta_clicked`
- `incoming_message`
- `outbound_message`
- `biodata_completed`
- `referral_submitted`

### `wa_admin_followups`

Menyimpan status follow-up admin:

- `pending`
- `in_progress`
- `done`

## Env Variables

### WhatsApp utama

- `WHATSAPP_BUSINESS_PHONE`
  - Nomor WhatsApp bisnis untuk CTA landing page.
- `WHATSAPP_API_VERSION`
  - Versi Graph API Meta.
- `WHATSAPP_PHONE_NUMBER_ID`
  - ID nomor dari WhatsApp Cloud API.
- `WHATSAPP_BUSINESS_ACCOUNT_ID`
  - ID akun bisnis WhatsApp.
- `WHATSAPP_ACCESS_TOKEN`
  - Token untuk kirim pesan outbound dari Laravel.
- `WHATSAPP_WEBHOOK_VERIFY_TOKEN`
  - Token verifikasi webhook saat setup di Meta developer.
- `WHATSAPP_DEFAULT_COUNTRY_CODE`
  - Untuk normalisasi nomor user, default `62`.
- `WHATSAPP_PREFILLED_MESSAGE`
  - Pesan awal saat CTA di-klik.

### Chatbot

- `WA_BOT_ENABLED`
  - Mengaktifkan atau menonaktifkan auto reply chatbot.
- `WA_BOT_WELCOME_MESSAGE`
  - Template sambutan dan format biodata.
- `WA_BOT_REFERRAL_PROMPT`
  - Pertanyaan referral setelah biodata selesai.
- `WA_BOT_COMPLETION_MESSAGE`
  - Pesan akhir sebelum admin takeover.
- `WA_BOT_FALLBACK_TO_GUIDED`
  - Jika `true`, bot bertanya satu-satu saat parsing gagal.

### Analytics

- `WA_TRACK_CTA`
  - Aktifkan tracking klik CTA.
- `WA_TRACK_INCOMING_MESSAGES`
  - Simpan chat masuk sebagai event analytics.

### Admin dashboard

- `ADMIN_NAME`
  - Nama akun admin awal yang dibuat oleh seeder.
- `ADMIN_EMAIL`
  - Email login admin awal.
- `ADMIN_PASSWORD`
  - Password login admin awal.

## Otorisasi admin

- Dashboard hotline sekarang memakai `auth` dan middleware `admin`.
- User harus login dan memiliki `is_admin = true`.
- Seeder admin default otomatis membuat akun admin dengan flag tersebut.

## Endpoint

- `GET /`
  - Landing page.
- `GET /admin/login`
  - Form login admin.
- `POST /admin/login`
  - Submit login admin.
- `POST /admin/logout`
  - Logout admin.
- `GET /go/whatsapp`
  - Track CTA dan redirect ke WhatsApp.
- `GET /api/webhooks/whatsapp`
  - Verifikasi webhook.
- `POST /api/webhooks/whatsapp`
  - Receiver event webhook WhatsApp.
- `GET /admin/hotline`
  - Dashboard hotline.
- `GET /admin/hotline/contacts/{contact}`
  - Detail user hotline.

## Setup Meta WhatsApp Cloud API

1. Buat App di Meta Developers.
2. Tambahkan product `WhatsApp`.
3. Ambil:
   - `Phone Number ID`
   - `Business Account ID`
   - `Access Token`
4. Arahkan webhook ke:
   - `https://domainkamu.com/api/webhooks/whatsapp`
5. Isi verify token di Meta sama dengan `WHATSAPP_WEBHOOK_VERIFY_TOKEN`.
6. Subscribe event pesan WhatsApp.

## Catatan Implementasi

- Parser biodata saat ini berbasis regex dan normalisasi sederhana.
- Dashboard sekarang sudah diproteksi session auth admin.
- Jika ingin parsing lebih fleksibel, nanti bisa ditambah fallback AI di service terpisah.
- Jika volume pesan tinggi, proses webhook sebaiknya dipindah ke queue/job.
- Seeder membuat satu admin default dan data dummy dashboard untuk preview lokal.
