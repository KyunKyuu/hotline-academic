# Meta Webhook Deploy Checklist

Checklist ini dipakai saat memindahkan project dari lokal ke server agar `WhatsApp Cloud API` bisa terhubung dengan benar.

## 1. Siapkan server Laravel

- Pastikan `APP_ENV=production`
- Pastikan `APP_DEBUG=false`
- Pastikan `APP_URL` mengarah ke domain final, misalnya `https://hotline.domainkamu.com`
- Jalankan:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 2. Isi env production

Wajib isi:

- `WHATSAPP_BUSINESS_PHONE`
- `WHATSAPP_API_VERSION`
- `WHATSAPP_PHONE_NUMBER_ID`
- `WHATSAPP_BUSINESS_ACCOUNT_ID`
- `WHATSAPP_ACCESS_TOKEN`
- `WHATSAPP_WEBHOOK_VERIFY_TOKEN`
- `WA_BOT_ENABLED=true`
- `WA_TRACK_CTA=true`
- `WA_TRACK_INCOMING_MESSAGES=true`

Admin awal:

- `ADMIN_NAME`
- `ADMIN_EMAIL`
- `ADMIN_PASSWORD`

## 3. Pastikan endpoint publik aktif

Endpoint yang harus bisa diakses publik:

- `GET /api/webhooks/whatsapp`
- `POST /api/webhooks/whatsapp`

Contoh final:

- `https://hotline.domainkamu.com/api/webhooks/whatsapp`

## 4. Hubungkan di Meta Developers

Di dashboard Meta:

1. Buka app yang memiliki product `WhatsApp`.
2. Masuk ke menu `Configuration`.
3. Isi callback URL:
   - `https://hotline.domainkamu.com/api/webhooks/whatsapp`
4. Isi verify token:
   - sama persis dengan `WHATSAPP_WEBHOOK_VERIFY_TOKEN`
5. Klik `Verify and save`.

## 5. Subscribe field webhook

Aktifkan field yang relevan, minimal:

- `messages`

Kalau nanti butuh status delivery, pastikan event status juga diproses.

## 6. Uji verifikasi webhook

Tes di browser:

```text
GET /api/webhooks/whatsapp?hub.mode=subscribe&hub.verify_token=YOUR_TOKEN&hub.challenge=123456
```

Hasil yang benar:

- response `200`
- body mengembalikan angka challenge, misalnya `123456`

## 7. Uji pesan masuk

Lakukan tes:

1. Klik CTA dari landing page.
2. Pastikan event `cta_clicked` masuk ke dashboard.
3. Kirim pesan pertama ke nomor bisnis WhatsApp.
4. Pastikan event `incoming_message` masuk.
5. Pastikan bot mengirim welcome message.
6. Lengkapi biodata dan referral.
7. Pastikan data masuk ke Group `A` atau `B`.

## 8. Queue dan worker

Untuk trafik awal, flow masih bisa langsung diproses di request webhook.

Untuk production yang lebih sibuk, siapkan:

- queue worker aktif
- retry strategy
- logging error webhook

Rekomendasi:

```bash
php artisan queue:work --tries=3
```

## 9. Keamanan minimum

- Gunakan token WhatsApp permanen yang aman
- Simpan `.env` hanya di server
- Lindungi route admin dengan password kuat
- Ganti default `ADMIN_PASSWORD`
- Aktifkan `HTTPS`
- Batasi akses panel admin jika memungkinkan

## 10. Final sanity check

Sebelum go-live, cek:

- landing page bisa dibuka
- tombol CTA redirect ke nomor yang benar
- webhook verify sukses
- pesan masuk tersimpan
- balasan bot terkirim
- dashboard admin bisa login
- data dummy sudah diganti atau dibersihkan jika tidak diperlukan
