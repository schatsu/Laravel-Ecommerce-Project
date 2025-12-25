<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CustomerInvoicesController;
use App\Http\Controllers\Front\FavoriteController;
use App\Http\Controllers\Front\ForgetPasswordController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LoginController;
use App\Http\Controllers\Front\OrderController;
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
        Route::get('adreslerim', [CustomerInvoicesController::class, 'index'])->name('address');
        Route::post('adres', [CustomerInvoicesController::class, 'store'])->name('address.store');
        Route::put('adres/{slug}', [CustomerInvoicesController::class, 'update'])->name('address.update');
        Route::patch('adres/{slug}/default', [CustomerInvoicesController::class, 'setDefault'])->name('address.setDefault');
        Route::delete('adres/{slug}', [CustomerInvoicesController::class, 'destroy'])->name('address.destroy');
        Route::get('hesap-detaylarim', [UserProfileController::class, 'accountDetails'])->name('account.details');
        Route::put('hesap-detaylari', [UserProfileController::class, 'updateAccountDetails'])->name('details.update');
        Route::get('cities/{countrySlug}', [UserProfileController::class, 'cities'])->name('cities');
        Route::get('districts/{citySlug}', [UserProfileController::class, 'districts'])->name('districts');
        Route::get('/favoriler', [FavoriteController::class, 'index'])->name('favorite.index');
        Route::post('/toggle/{slug}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
        Route::get('/siparislerim', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/siparislerim/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/kuponlarim', [UserProfileController::class, 'coupons'])->name('coupons');
        Route::post('/adres/ajax', [CustomerInvoicesController::class, 'storeAjax'])->name('address.storeAjax');
    });

    // Checkout Routes
    Route::prefix('odeme')->as('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/form/{order}', [CheckoutController::class, 'paymentForm'])->name('payment-form');
        Route::post('/pay', [CheckoutController::class, 'pay'])->name('pay');
        Route::get('/installments/{bin}/{price}', [CheckoutController::class, 'getInstallments'])->name('installments');
    });

    Route::post('cikis', [LoginController::class, 'logout'])->name('logout');
});

// 3D Callback ve sonuç sayfaları - auth dışında
Route::post('/odeme/3d-callback', [CheckoutController::class, 'threeDCallback'])->name('checkout.3d-callback');
Route::get('/odeme/basarili/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/odeme/basarisiz', [CheckoutController::class, 'fail'])->name('checkout.fail');

Route::get('/', HomeController::class)->name('home');
Route::get('kategoriler', [CategoryController::class, 'index'])->name('category.index');
Route::get('kategori/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('urun/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/quick-view/{product}', [ProductController::class, 'quickView'])->name('product.quick-view');

Route::prefix('sepet')->as('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::get('/mini', [CartController::class, 'show'])->name('show');
    Route::post('/', [CartController::class, 'store'])->name('store');
    Route::patch('/items/{item}', [CartController::class, 'update'])->name('update');
    Route::delete('/items/{item}', [CartController::class, 'destroy'])->name('destroy');
    Route::delete('/', [CartController::class, 'destroyAll'])->name('destroyAll');
    Route::post('/coupon', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::delete('/coupon', [CartController::class, 'removeCoupon'])->name('coupon.remove');
});
