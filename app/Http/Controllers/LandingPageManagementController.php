<?php

namespace App\Http\Controllers;

use App\Models\LandingSetting;
use App\Models\ActivityMoment;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageManagementController extends Controller
{
    public function index(): View
    {
        $setting = LandingSetting::firstOrCreate([
            'id' => 1
        ], [
            'hero_type' => 'video',
            'hero_title' => 'Unggul dalam Ilmu.',
            'hero_subtitle' => 'Satu ruang belajar bagi pelajar dan mahasiswa muslim Indonesia — tempat akademik dan keislaman tumbuh bersama.',
        ]);

        return view('admin.landing.index', compact('setting'));
    }

    public function momentsIndex(): View
    {
        $moments = ActivityMoment::orderBy('order')->orderBy('id')->get();
        return view('admin.landing.moments.index', compact('moments'));
    }

    public function partnersIndex(): View
    {
        $partners = Partner::orderBy('id')->get();
        return view('admin.landing.partners.index', compact('partners'));
    }

    public function updateHero(Request $request): RedirectResponse
    {
        $setting = LandingSetting::firstOrCreate(['id' => 1]);

        $data = $request->validate([
            'hero_type' => ['required', 'in:pattern,image,video'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'image', 'max:10240'], // max 10MB
            'hero_video' => ['nullable', 'mimetypes:video/mp4', 'max:51200'], // max 50MB
        ]);

        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $filename = 'hero_' . time() . '.' . $file->extension();
            
            // Ensure directory exists
            $path = public_path('images/hero');
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            
            $file->move($path, $filename);
            $data['hero_image'] = $filename;
        }

        if ($request->hasFile('hero_video')) {
            $file = $request->file('hero_video');
            $filename = 'hero_' . time() . '.' . $file->extension();
            
            // Ensure directory exists
            $path = public_path('videos');
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            
            $file->move($path, $filename);
            $data['hero_video'] = $filename;
        }

        $setting->update($data);

        return redirect()->route('admin.landing.index')->with('status', 'Pengaturan Hero berhasil diperbarui.');
    }

    // --- MOMENTS CRUD ---

    public function momentsCreate(): View
    {
        return view('admin.landing.moments.form', [
            'moment' => new ActivityMoment(),
        ]);
    }

    public function momentsStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'image' => ['required', 'image', 'max:5120'], // max 5MB
            'caption' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'moment_' . uniqid() . '.' . $file->extension();
            
            $path = public_path('images/gallery');
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            
            $file->move($path, $filename);
            $data['image'] = $filename;
        }

        ActivityMoment::create($data);

        return redirect()->route('admin.landing.index')->with('status', 'Momen Kegiatan berhasil ditambahkan.');
    }

    public function momentsEdit(ActivityMoment $moment): View
    {
        return view('admin.landing.moments.form', compact('moment'));
    }

    public function momentsUpdate(Request $request, ActivityMoment $moment): RedirectResponse
    {
        $data = $request->validate([
            'image' => ['nullable', 'image', 'max:5120'],
            'caption' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'moment_' . uniqid() . '.' . $file->extension();
            
            $path = public_path('images/gallery');
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            
            $file->move($path, $filename);
            $data['image'] = $filename;
        }

        $moment->update($data);

        return redirect()->route('admin.landing.index')->with('status', 'Momen Kegiatan berhasil diperbarui.');
    }

    public function momentsDestroy(ActivityMoment $moment): RedirectResponse
    {
        // Delete physical file if exists
        $filePath = public_path('images/gallery/' . $moment->image);
        if (is_file($filePath)) {
            @unlink($filePath);
        }

        $moment->delete();

        return redirect()->route('admin.landing.index')->with('status', 'Momen Kegiatan berhasil dihapus.');
    }

    // --- PARTNERS CRUD ---

    public function partnersCreate(): View
    {
        return view('admin.landing.partners.form', [
            'partner' => new Partner(),
        ]);
    }

    public function partnersStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:partners,slug'],
            'tagline' => ['nullable', 'string', 'max:150'],
            'logo' => ['required', 'image', 'max:2048'], // max 2MB
            'profile' => ['nullable', 'string'],
            'activities' => ['nullable', 'array'],
            'activities.*.title' => ['required_with:activities.*.description', 'nullable', 'string', 'max:255'],
            'activities.*.description' => ['required_with:activities.*.title', 'nullable', 'string'],
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'partner_' . uniqid() . '.' . $file->extension();
            
            $path = public_path('images/partners');
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            
            $file->move($path, $filename);
            $data['logo'] = $filename;
        }

        // Clean activities array of null/empty values
        if (isset($data['activities'])) {
            $data['activities'] = array_values(array_filter($data['activities'], function ($act) {
                return !empty($act['title']) && !empty($act['description']);
            }));
        } else {
            $data['activities'] = [];
        }

        Partner::create($data);

        return redirect()->route('admin.landing.index')->with('status', 'Partner Komunitas berhasil ditambahkan.');
    }

    public function partnersEdit(Partner $partner): View
    {
        return view('admin.landing.partners.form', compact('partner'));
    }

    public function partnersUpdate(Request $request, Partner $partner): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:partners,slug,' . $partner->id],
            'tagline' => ['nullable', 'string', 'max:150'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'profile' => ['nullable', 'string'],
            'activities' => ['nullable', 'array'],
            'activities.*.title' => ['required_with:activities.*.description', 'nullable', 'string', 'max:255'],
            'activities.*.description' => ['required_with:activities.*.title', 'nullable', 'string'],
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'partner_' . uniqid() . '.' . $file->extension();
            
            $path = public_path('images/partners');
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            
            $file->move($path, $filename);
            $data['logo'] = $filename;

            // Delete old file if exists
            $oldFilePath = public_path('images/partners/' . $partner->logo);
            if (is_file($oldFilePath)) {
                @unlink($oldFilePath);
            }
        }

        // Clean activities array
        if (isset($data['activities'])) {
            $data['activities'] = array_values(array_filter($data['activities'], function ($act) {
                return !empty($act['title']) && !empty($act['description']);
            }));
        } else {
            $data['activities'] = [];
        }

        $partner->update($data);

        return redirect()->route('admin.landing.index')->with('status', 'Partner Komunitas berhasil diperbarui.');
    }

    public function partnersDestroy(Partner $partner): RedirectResponse
    {
        // Delete physical file if exists
        $filePath = public_path('images/partners/' . $partner->logo);
        if (is_file($filePath)) {
            @unlink($filePath);
        }

        $partner->delete();

        return redirect()->route('admin.landing.index')->with('status', 'Partner Komunitas berhasil dihapus.');
    }
}
