<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seeds placeholder articles so the /artikel feature is demonstrable out of
     * the box. Replace or delete these from /admin/articles once real activity
     * reports are ready — titles are intentionally labelled "Contoh" (example)
     * so nobody mistakes them for real reported events.
     */
    public function run(): void
    {
        $examples = [
            [
                'title' => 'Contoh Artikel 1 — Ganti dengan Berita Kegiatan Asli',
                'excerpt' => 'Ini adalah artikel contoh. Edit atau hapus lewat halaman admin, lalu ganti dengan laporan kegiatan MLUP Academy yang sesungguhnya.',
                'body' => "Ini adalah isi artikel contoh.\n\nGunakan halaman /admin/articles untuk mengedit judul, ringkasan, isi, dan foto sampul artikel ini, atau hapus dan buat artikel baru berisi laporan kegiatan MLUP Academy yang sesungguhnya.",
            ],
            [
                'title' => 'Contoh Artikel 2 — Ganti dengan Berita Kegiatan Asli',
                'excerpt' => 'Ini adalah artikel contoh kedua, untuk menunjukkan tampilan daftar artikel dengan lebih dari satu entri.',
                'body' => "Ini adalah isi artikel contoh kedua.\n\nSetiap artikel yang dipublikasikan lewat halaman admin akan otomatis muncul di sini dan di beranda, diurutkan dari yang terbaru.",
            ],
            [
                'title' => 'Contoh Artikel 3 — Ganti dengan Berita Kegiatan Asli',
                'excerpt' => 'Ini adalah artikel contoh ketiga, lengkapi dengan foto sampul saat mengganti kontennya.',
                'body' => "Ini adalah isi artikel contoh ketiga.\n\nTambahkan foto sampul lewat form admin agar tampilan kartu artikel di beranda lebih menarik.",
            ],
        ];

        foreach ($examples as $index => $example) {
            Article::updateOrCreate(
                ['slug' => Str::slug($example['title'])],
                [
                    ...$example,
                    'published_at' => now()->subDays(count($examples) - $index),
                ]
            );
        }
    }
}
