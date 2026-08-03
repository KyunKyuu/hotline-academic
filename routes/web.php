<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleManagementController;
use App\Http\Controllers\HotlineDashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LandingPageManagementController;
use App\Http\Controllers\Auth\AdminAuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/komunitas/{slug}', [LandingPageController::class, 'community'])->name('landing.community.show');
Route::get('/go/whatsapp', [LandingPageController::class, 'redirectToWhatsApp'])->name('landing.whatsapp.redirect');

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{article}', [ArticleController::class, 'show'])->name('articles.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/admin/login', [AdminAuthenticatedSessionController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthenticatedSessionController::class, 'store'])->name('admin.login.store');
});

Route::middleware(['auth', 'admin'])->group(function (): void {
    Route::post('/admin/logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('admin.logout');

    Route::prefix('admin/hotline')->group(function (): void {
        Route::get('/', [HotlineDashboardController::class, 'index'])->name('hotline.dashboard');
        Route::get('/contacts/{contact}', [HotlineDashboardController::class, 'show'])->name('hotline.contacts.show');
        Route::patch('/contacts/{contact}/follow-up', [HotlineDashboardController::class, 'updateFollowUp'])->name('hotline.contacts.follow-up');
    });

    Route::prefix('admin/articles')->name('admin.articles.')->group(function (): void {
        Route::get('/', [ArticleManagementController::class, 'index'])->name('index');
        Route::get('/create', [ArticleManagementController::class, 'create'])->name('create');
        Route::post('/', [ArticleManagementController::class, 'store'])->name('store');
        Route::get('/{article}/edit', [ArticleManagementController::class, 'edit'])->name('edit');
        Route::put('/{article}', [ArticleManagementController::class, 'update'])->name('update');
        Route::delete('/{article}', [ArticleManagementController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin/landing')->name('admin.landing.')->group(function (): void {
        Route::get('/', [LandingPageManagementController::class, 'index'])->name('index');
        Route::post('/hero', [LandingPageManagementController::class, 'updateHero'])->name('hero.update');

        Route::prefix('moments')->name('moments.')->group(function (): void {
            Route::get('/', [LandingPageManagementController::class, 'momentsIndex'])->name('index');
            Route::get('/create', [LandingPageManagementController::class, 'momentsCreate'])->name('create');
            Route::post('/', [LandingPageManagementController::class, 'momentsStore'])->name('store');
            Route::get('/{moment}/edit', [LandingPageManagementController::class, 'momentsEdit'])->name('edit');
            Route::put('/{moment}', [LandingPageManagementController::class, 'momentsUpdate'])->name('update');
            Route::delete('/{moment}', [LandingPageManagementController::class, 'momentsDestroy'])->name('destroy');
        });

        Route::prefix('partners')->name('partners.')->group(function (): void {
            Route::get('/', [LandingPageManagementController::class, 'partnersIndex'])->name('index');
            Route::get('/create', [LandingPageManagementController::class, 'partnersCreate'])->name('create');
            Route::post('/', [LandingPageManagementController::class, 'partnersStore'])->name('store');
            Route::get('/{partner}/edit', [LandingPageManagementController::class, 'partnersEdit'])->name('edit');
            Route::put('/{partner}', [LandingPageManagementController::class, 'partnersUpdate'])->name('update');
            Route::delete('/{partner}', [LandingPageManagementController::class, 'partnersDestroy'])->name('destroy');
        });

        Route::prefix('testimonials')->name('testimonials.')->group(function (): void {
            Route::get('/', [LandingPageManagementController::class, 'testimonialsIndex'])->name('index');
            Route::get('/create', [LandingPageManagementController::class, 'testimonialsCreate'])->name('create');
            Route::post('/', [LandingPageManagementController::class, 'testimonialsStore'])->name('store');
            Route::get('/{testimonial}/edit', [LandingPageManagementController::class, 'testimonialsEdit'])->name('edit');
            Route::put('/{testimonial}', [LandingPageManagementController::class, 'testimonialsUpdate'])->name('update');
            Route::delete('/{testimonial}', [LandingPageManagementController::class, 'testimonialsDestroy'])->name('destroy');
        });
    });
});
