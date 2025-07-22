<?php

use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\Front\CustomerInvoicesController;
use App\Http\Controllers\Front\ForgetPasswordController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LoginController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\RegisterController;
use App\Http\Controllers\Front\ResetPasswordController;
use App\Http\Controllers\Front\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/kayit-ol', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/kayit-ol', [RegisterController::class, 'register']);
    Route::get('/giris-yap', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/giris-yap', [LoginController::class, 'login']);

    Route::post('sifre/eposta', [ForgetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('sifre/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('sifre/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('profil')->as('account.')->group(function () {
        Route::get('hesabim', [UserProfileController::class, 'account'])->name('index');
        Route::get('adres', [CustomerInvoicesController::class, 'index'])->name('address');
        Route::post('adres', [CustomerInvoicesController::class, 'store'])->name('address.store');
        Route::put('adres/{slug}', [CustomerInvoicesController::class, 'update'])->name('address.update');
        Route::delete('adres/{slug}', [CustomerInvoicesController::class, 'destroy'])->name('address.destroy');
        Route::get('hesap-detaylari', [UserProfileController::class, 'accountDetails'])->name('account.details');
        Route::get('cities/{countrySlug}', [UserProfileController::class, 'cities'])->name('cities');
        Route::get('districts/{citySlug}', [UserProfileController::class, 'districts'])->name('districts');
    });
    Route::post('cikis', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/', HomeController::class)->name('home');
Route::get('kategoriler', [CategoryController::class, 'index'])->name('category.index');
Route::get('kategori/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('urun/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/quick-view/{product}', [ProductController::class, 'quickView'])->name('product.quick-view');

