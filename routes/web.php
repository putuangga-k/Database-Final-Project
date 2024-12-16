<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PusatController;
use App\Http\Controllers\StokisController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VendorPriceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\FaktaPenjualanController;
use App\Http\Controllers\CombinedDashboardController;

Route::middleware('guest')->group(function () {
    // Halaman login
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    // Halaman signup
    Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');

    // Proses login dan signup
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/signup', [AuthController::class, 'signup'])->name('signup.post');
});

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function() {
        return redirect()->route('dashboard.combined');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Resource Routes untuk CRUD operasi
    Route::resource('produk', ProdukController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('pusats', PusatController::class);
    Route::resource('stokis', StokisController::class)->parameters([
        'stokis' => 'stokis',
    ]);    
    Route::resource('mitras', MitraController::class);
    Route::resource('pembelians', PembelianController::class);
    Route::resource('pengirimans', PengirimanController::class);
    Route::get('/stokis/search', [App\Http\Controllers\StokisController::class, 'search'])->name('stokis.search');
    Route::get('inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
    Route::resource('categories', CategoryController::class);
    Route::resource('vendor_prices', VendorPriceController::class);
    Route::post('vendor_prices/import', [VendorPriceController::class, 'import'])->name('vendor_prices.import');
    Route::resource('locations', LocationController::class);
    Route::get('/fakta_penjualan', [FaktaPenjualanController::class, 'index'])->name('fakta_penjualan');
    Route::get('/dashboard.info', [DashboardController::class, 'index'])->name('dashboard.info');
    Route::get('/dashboard.combined', [CombinedDashboardController::class, 'index'])->name('dashboard.combined');
});