<?php

namespace Database\Seeders;

use App\Models\LandingSetting;
use App\Models\ActivityMoment;
use App\Models\Partner;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Landing Settings (Hero)
        LandingSetting::updateOrCreate(
            ['id' => 1],
            [
                'hero_type' => 'video',
                'hero_image' => null,
                'hero_video' => null,
                'hero_title' => 'Unggul dalam Ilmu.',
                'hero_subtitle' => 'Satu ruang belajar bagi pelajar dan mahasiswa muslim Indonesia — tempat akademik dan keislaman tumbuh bersama.',
            ]
        );

        // Seed Activity Moments
        $moments = [
            ['image' => 'gallery-4.jpg', 'caption' => 'Kolaborasi lintas kampus', 'order' => 1],
            ['image' => 'gallery-5.jpg', 'caption' => 'Diskusi & pengembangan karier', 'order' => 2],
            ['image' => 'gallery-6.jpg', 'caption' => 'Penyaluran bantuan pendidikan', 'order' => 3],
            ['image' => 'gallery-7.jpg', 'caption' => 'Silaturahmi komunitas', 'order' => 4],
            ['image' => 'gallery-8.jpg', 'caption' => 'Momen belajar bersama', 'order' => 5],
        ];

        foreach ($moments as $moment) {
            ActivityMoment::updateOrCreate(
                ['image' => $moment['image']],
                [
                    'caption' => $moment['caption'],
                    'order' => $moment['order']
                ]
            );
        }

        // Seed Partner Communities
        $partners = [
            [
                'slug' => 'ufairah',
                'name' => 'Ufairah',
                'tagline' => 'Komunitas mitra MLUP Academy',
                'logo' => 'ufairah.png',
                'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                'activities' => [
                    ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.']
                ]
            ],
            [
                'slug' => 'rest-area',
                'name' => 'Rest Area',
                'tagline' => 'Komunitas mitra MLUP Academy',
                'logo' => 'rest-area.png',
                'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                'activities' => [
                    ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.']
                ]
            ],
            [
                'slug' => 'gemusi',
                'name' => 'GEMUSI',
                'tagline' => 'Generasi Muslim Berprestasi',
                'logo' => 'gemusi.png',
                'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                'activities' => [
                    ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.']
                ]
            ],
            [
                'slug' => 'bliss',
                'name' => 'BLISS Community',
                'tagline' => 'Komunitas mitra MLUP Academy',
                'logo' => 'bliss.png',
                'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                'activities' => [
                    ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.']
                ]
            ],
            [
                'slug' => 'ruang-alara',
                'name' => 'Ruang Alara',
                'tagline' => 'Komunitas mitra MLUP Academy',
                'logo' => 'ruang-alara.png',
                'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                'activities' => [
                    ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.']
                ]
            ],
            [
                'slug' => 'hawa',
                'name' => 'HAWA',
                'tagline' => 'Komunitas mitra MLUP Academy',
                'logo' => 'hawa.png',
                'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                'activities' => [
                    ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.']
                ]
            ],
            [
                'slug' => 'craftiva',
                'name' => 'Craftiva',
                'tagline' => 'Komunitas mitra MLUP Academy',
                'logo' => 'craftiva.png',
                'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                'activities' => [
                    ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.']
                ]
            ],
        ];

        foreach ($partners as $partner) {
            Partner::updateOrCreate(
                ['slug' => $partner['slug']],
                [
                    'name' => $partner['name'],
                    'tagline' => $partner['tagline'],
                    'logo' => $partner['logo'],
                    'profile' => $partner['profile'],
                    'activities' => $partner['activities']
                ]
            );
        }
    }
}
