<?php

use App\Http\Controllers\HotlineDashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Auth\AdminAuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/go/whatsapp', [LandingPageController::class, 'redirectToWhatsApp'])->name('landing.whatsapp.redirect');

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
});
