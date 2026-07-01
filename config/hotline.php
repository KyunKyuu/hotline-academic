<?php

return [
    'default_country_code' => env('WHATSAPP_DEFAULT_COUNTRY_CODE', '62'),
    'api_version' => env('WHATSAPP_API_VERSION', 'v23.0'),
    'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
    'business_account_id' => env('WHATSAPP_BUSINESS_ACCOUNT_ID'),
    'access_token' => env('WHATSAPP_ACCESS_TOKEN'),
    'webhook_verify_token' => env('WHATSAPP_WEBHOOK_VERIFY_TOKEN'),
    'business_phone' => env('WHATSAPP_BUSINESS_PHONE'),
    'prefilled_message' => env('WHATSAPP_PREFILLED_MESSAGE', 'Halo, saya ingin bertanya tentang hotline akademik.'),
    'bot_enabled' => env('WA_BOT_ENABLED', true),
    'track_cta' => env('WA_TRACK_CTA', true),
    'track_incoming_messages' => env('WA_TRACK_INCOMING_MESSAGES', true),
    'guided_fallback' => env('WA_BOT_FALLBACK_TO_GUIDED', true),
    'welcome_message' => env('WA_BOT_WELCOME_MESSAGE', "Halo, selamat datang di Hotline Akademik.\n\nSilakan balas dengan format berikut:\nNama: \nSemester: \nKampus: \nJurusan: "),
    'referral_prompt' => env('WA_BOT_REFERRAL_PROMPT', "Jika punya kode referral, balas sekarang.\nJika tidak ada, balas: tidak ada"),
    'completion_message' => env('WA_BOT_COMPLETION_MESSAGE', 'Terima kasih. Data Anda sudah kami terima dan admin akan segera menghubungi Anda.'),
];
