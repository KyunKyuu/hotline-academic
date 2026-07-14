<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\WaAnalyticsEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    public function index(): View
    {
        $content = $this->landingContent();

        $gallery = array_map(fn (array $item) => $this->attachExists($item, 'gallery'), $content['gallery']);

        $content['approachPhotos'] = array_slice($gallery, 0, 3);
        $content['proofGallery'] = array_slice($gallery, 3);
        $content['partners'] = array_map([$this, 'withLogo'], $content['partners']);
        $content['decor'] = array_map(fn (array $item) => $this->attachExists($item, 'gallery'), $content['decor']);
        $content['latestArticles'] = Article::query()->published()->latest('published_at')->limit(3)->get();
        $content['heroVideoExists'] = is_file(public_path('videos/hero.mp4'));
        unset($content['gallery']);

        return view('landing.index', $content);
    }

    public function community(string $slug): View
    {
        $partner = collect($this->landingContent()['partners'])
            ->firstWhere('slug', $slug);

        abort_if($partner === null, 404);

        return view('landing.community', [
            'partner' => $this->withLogo($partner),
            'title' => $partner['name'].' — MLUP Academy',
        ]);
    }

    private function withLogo(array $partner): array
    {
        $partner['logo'] = $this->attachExists($partner['logo'], 'partners');

        return $partner;
    }

    private function attachExists(array $item, string $folder): array
    {
        $item['exists'] = is_file(public_path('images/'.$folder.'/'.$item['file']));

        return $item;
    }

    /**
     * Structured content for the foundation landing page. Kept as plain arrays
     * so sections can later be swapped for database-backed models (e.g. programs)
     * without touching the view.
     */
    private function landingContent(): array
    {
        return [
            'problems' => [
                [
                    'title' => 'Biaya pendidikan terus meningkat',
                    'description' => 'Banyak mahasiswa muslim berhenti kuliah karena keterbatasan biaya, bukan karena keterbatasan kemampuan.',
                ],
                [
                    'title' => 'Mentoring belum merata',
                    'description' => 'Kesempatan memperoleh bimbingan akademik dan karier berkualitas belum dapat diakses semua orang.',
                ],
                [
                    'title' => 'Paradigma yang memisahkan',
                    'description' => 'Masih ada anggapan bahwa mengejar pendidikan tinggi, prestasi akademik, dan kualitas iman adalah tiga hal yang sulit dijalankan bersamaan.',
                ],
            ],

            'approaches' => [
                [
                    'label' => '01',
                    'title' => 'Pendidikan',
                    'description' => 'Ilmu diajarkan oleh orang-orang yang benar-benar menguasai bidangnya — fokus pada kualitas keilmuan, bukan sekadar berbagi materi.',
                ],
                [
                    'label' => '02',
                    'title' => 'Program Sosial',
                    'description' => 'Kepedulian diwujudkan melalui program nyata yang berdampak langsung, bukan sekadar kegiatan simbolis.',
                ],
                [
                    'label' => '03',
                    'title' => 'Nilai Islam',
                    'description' => 'Islam bukan sekadar identitas organisasi, tetapi cara hidup yang membimbing seluruh aktivitas komunitas.',
                ],
            ],

            'targets' => ['Pelajar muslim', 'Mahasiswa muslim', 'Generasi Z', 'Profesional muda', 'Donatur'],

            'fields' => ['Pendidikan', 'Akademik', 'Pengembangan komunitas', 'Kolaborasi', 'Program sosial', 'Konten Islami', 'Media Islami'],

            'paradigms' => [
                [
                    'topic' => 'Keilmuan vs. Keislaman',
                    'old' => 'Menjadi alim dan menjadi unggul dianggap sebagai dua jalan yang berbeda.',
                    'new' => 'Keilmuan dan keislaman dapat berkembang bersama, dalam satu ekosistem yang sama.',
                ],
                [
                    'topic' => 'Biaya Pendidikan',
                    'old' => 'Mahasiswa dengan keterbatasan biaya dianggap harus menerima keadaan.',
                    'new' => 'Keterbatasan biaya tidak boleh menghentikan seseorang untuk belajar.',
                ],
                [
                    'topic' => 'Ilmu vs. Iman',
                    'old' => 'Generasi muslim harus memilih: mengejar ilmu, atau menjaga iman.',
                    'new' => 'Keduanya harus tumbuh secara bersamaan, tanpa harus mengorbankan salah satunya.',
                ],
            ],

            'pillars' => [
                [
                    'title' => 'Merobohkan Sekat Keilmuan dan Keislaman',
                    'description' => 'Menolak anggapan bahwa serius belajar berarti longgar beragama, atau religius berarti kurang unggul secara akademik.',
                ],
                [
                    'title' => 'Mencetak Rujukan, Bukan Sekadar Lulusan',
                    'description' => 'Target akhirnya bukan sekadar gelar, tetapi melahirkan sosok yang menjadi tempat bertanya, teladan, dan bermanfaat bagi masyarakat.',
                ],
                [
                    'title' => 'Menghapus Alasan "Tidak Mampu"',
                    'description' => 'Memastikan biaya, akses, dan kondisi ekonomi tidak lagi menjadi alasan seseorang berhenti belajar.',
                ],
                [
                    'title' => 'Merawat Ekosistem',
                    'description' => 'Membangun jaringan, komunitas, budaya saling membantu, serta kolaborasi lintas kampus dan lintas kota.',
                ],
            ],

            'missions' => [
                [
                    'title' => 'Membongkar Sekat Paradigma',
                    'summary' => 'Membongkar sekat antara ruang keilmuan dan ruang iman.',
                    'points' => [
                        'Membuka akses pendidikan bagi siapa pun.',
                        'Menyediakan ruang belajar yang terbuka.',
                        'Memberi kesempatan setara untuk berkembang.',
                    ],
                ],
                [
                    'title' => 'Mengawal Kuliah hingga Profesi',
                    'summary' => 'Mengawal mahasiswa muslim sejak masa kuliah hingga memasuki dunia profesi.',
                    'points' => [
                        'Mentoring akademik.',
                        'Pembinaan karier.',
                        'Pengembangan profesional.',
                        'Menghasilkan sosok yang menjadi rujukan.',
                    ],
                ],
                [
                    'title' => 'Menghilangkan Hambatan Biaya',
                    'summary' => 'Menghilangkan hambatan biaya pendidikan bagi mahasiswa muslim.',
                    'points' => [
                        'Menghimpun kebaikan dari masyarakat.',
                        'Menyalurkan bantuan pendidikan.',
                        'Memastikan mahasiswa tidak berhenti kuliah karena alasan ekonomi.',
                    ],
                ],
                [
                    'title' => 'Membangun Ekosistem Saling Menguatkan',
                    'summary' => 'Membangun ekosistem generasi muslim yang saling menguatkan.',
                    'points' => [
                        'Membangun komunitas.',
                        'Memperkuat jaringan.',
                        'Mendorong kolaborasi.',
                        'Menciptakan budaya saling membantu.',
                    ],
                ],
            ],

            'values' => [
                ['title' => 'Akademik', 'icon' => 'academic-cap', 'description' => 'Serius dalam belajar, menghargai proses, dan menghormati perjalanan panjang keilmuan.'],
                ['title' => 'Keilmuan', 'icon' => 'book-open', 'description' => 'Berpijak pada ilmu, menghindari asumsi, dan tidak sekadar mengikuti tradisi tanpa dasar.'],
                ['title' => 'Keprofesian', 'icon' => 'briefcase', 'description' => 'Amanah, profesional, terukur, dan bertanggung jawab dalam setiap tindakan.'],
                ['title' => 'Sosial', 'icon' => 'heart', 'description' => 'Kepedulian diwujudkan dalam tindakan nyata, bukan hanya slogan atau solidaritas simbolis.'],
                ['title' => 'Islam', 'icon' => 'moon-star', 'description' => 'Dijadikan sebagai cara hidup, menjadi dasar dalam program, konten, keputusan, dan budaya organisasi.'],
            ],

            // Empty for now — ready to be swapped for a Program model/query once
            // the program catalogue (portofolio, ekosistem, roadmap) is finalized.
            'programs' => [],

            // Real partner communities — profile/activities copy stays generic
            // until each community shares their actual write-up.
            'partners' => [
                [
                    'slug' => 'ufairah',
                    'name' => 'Ufairah',
                    'tagline' => 'Komunitas mitra MLUP Academy',
                    'logo' => ['file' => 'ufairah.png', 'caption' => 'Ufairah'],
                    'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                    'activities' => [
                        ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.'],
                    ],
                ],
                [
                    'slug' => 'rest-area',
                    'name' => 'Rest Area',
                    'tagline' => 'Komunitas mitra MLUP Academy',
                    'logo' => ['file' => 'rest-area.png', 'caption' => 'Rest Area'],
                    'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                    'activities' => [
                        ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.'],
                    ],
                ],
                [
                    'slug' => 'gemusi',
                    'name' => 'GEMUSI',
                    'tagline' => 'Generasi Muslim Berprestasi',
                    'logo' => ['file' => 'gemusi.png', 'caption' => 'GEMUSI'],
                    'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                    'activities' => [
                        ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.'],
                    ],
                ],
                [
                    'slug' => 'bliss',
                    'name' => 'BLISS Community',
                    'tagline' => 'Komunitas mitra MLUP Academy',
                    'logo' => ['file' => 'bliss.png', 'caption' => 'BLISS Community'],
                    'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                    'activities' => [
                        ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.'],
                    ],
                ],
                [
                    'slug' => 'ruang-alara',
                    'name' => 'Ruang Alara',
                    'tagline' => 'Komunitas mitra MLUP Academy',
                    'logo' => ['file' => 'ruang-alara.png', 'caption' => 'Ruang Alara'],
                    'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                    'activities' => [
                        ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.'],
                    ],
                ],
                [
                    'slug' => 'hawa',
                    'name' => 'HAWA',
                    'tagline' => 'Komunitas mitra MLUP Academy',
                    'logo' => ['file' => 'hawa.png', 'caption' => 'HAWA'],
                    'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                    'activities' => [
                        ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.'],
                    ],
                ],
                [
                    'slug' => 'craftiva',
                    'name' => 'Craftiva',
                    'tagline' => 'Komunitas mitra MLUP Academy',
                    'logo' => ['file' => 'craftiva.png', 'caption' => 'Craftiva'],
                    'profile' => 'Profil komunitas mitra akan ditampilkan di sini setelah materi resmi tersedia.',
                    'activities' => [
                        ['title' => 'Kegiatan bersama 1', 'description' => 'Deskripsi kegiatan akan ditambahkan setelah program berjalan.'],
                    ],
                ],
            ],

            'roadmap' => [
                [
                    'label' => 'Beasiswa MLUP',
                    'icon' => 'academic-cap',
                    'description' => 'Bantuan pendidikan yang disalurkan langsung dari kebaikan komunitas untuk mahasiswa yang membutuhkan.',
                ],
                [
                    'label' => 'LINTAS',
                    'icon' => 'handshake',
                    'description' => 'Program kolaborasi lintas kampus dan lintas kota untuk memperluas jaringan ekosistem MLUP Academy.',
                ],
            ],

            'wings' => [
                [
                    'title' => 'Literasi',
                    'icon' => 'book-open',
                    'description' => 'Konten dan bacaan yang memperkaya wawasan akademik sekaligus keislaman.',
                ],
                [
                    'title' => 'Workshop',
                    'icon' => 'briefcase',
                    'description' => 'Sesi belajar interaktif bersama mentor dan praktisi di bidangnya.',
                ],
                [
                    'title' => 'Online Course',
                    'icon' => 'academic-cap',
                    'description' => 'Kelas daring terstruktur yang bisa diakses kapan pun, di mana pun.',
                ],
            ],

            // Purely decorative photo trio used as a visual breather between
            // text-heavy sections — same drop-in-file convention as 'gallery'.
            'decor' => [
                ['file' => 'gallery-9.jpg', 'caption' => 'Momen MLUP Academy'],
                ['file' => 'gallery-10.jpg', 'caption' => 'Momen MLUP Academy'],
                ['file' => 'gallery-11.jpg', 'caption' => 'Momen MLUP Academy'],
            ],

            // Drop real photos into public/images/gallery using these exact
            // filenames and they render automatically — no code change needed.
            // Until a file exists, the section falls back to a styled placeholder.
            'gallery' => [
                ['file' => 'gallery-1.jpg', 'caption' => 'Kelas mentoring akademik'],
                ['file' => 'gallery-2.jpg', 'caption' => 'Program sosial & bantuan pendidikan'],
                ['file' => 'gallery-3.jpg', 'caption' => 'Kajian & pembinaan keislaman'],
                ['file' => 'gallery-4.jpg', 'caption' => 'Kolaborasi lintas kampus'],
                ['file' => 'gallery-5.jpg', 'caption' => 'Diskusi & pengembangan karier'],
                ['file' => 'gallery-6.jpg', 'caption' => 'Penyaluran bantuan pendidikan'],
                ['file' => 'gallery-7.jpg', 'caption' => 'Silaturahmi komunitas'],
                ['file' => 'gallery-8.jpg', 'caption' => 'Momen belajar bersama'],
            ],
        ];
    }

    public function redirectToWhatsApp(Request $request): RedirectResponse
    {
        $source = $request->string('source', 'landing_page')->value();
        $campaign = $request->string('campaign', 'default')->value();
        $clickToken = 'CTA-'.Str::upper(Str::random(8));
        $message = trim(config('hotline.prefilled_message').' Ref: '.$clickToken);

        if (config('hotline.track_cta')) {
            WaAnalyticsEvent::create([
                'event_type' => 'cta_clicked',
                'source' => $source,
                'campaign' => $campaign,
                'reference' => $clickToken,
                'payload' => [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'query' => $request->query(),
                ],
                'occurred_at' => now(),
            ]);
        }

        $phone = preg_replace('/\D+/', '', (string) config('hotline.business_phone')) ?: '';

        if (Str::startsWith($phone, '0')) {
            $phone = config('hotline.default_country_code').substr($phone, 1);
        }

        if ($phone === '') {
            return redirect()->route('landing.index');
        }

        return redirect()->away('https://wa.me/'.$phone.'?text='.urlencode($message));
    }
}
