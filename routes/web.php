<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// ✅ Halaman utama (welcome)
Route::get('/', function () {
    return view('welcome');
});

// ✅ Dashboard umum (opsional, bisa dipakai semua yang login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ✅ Halaman ADMIN (khusus admin)
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/admin', function () {
        return view('admin.admin');
    })->name('admin.dashboard');

    // CRUD Produk
    Route::prefix('admin')->group(function () {

        // INDEX (halaman list produk)
        Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])
            ->name('admin.products.index');

        // STORE (tambah produk)
        Route::post('/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])
            ->name('admin.products.store');

        // SHOW (ambil data untuk modal edit)
        Route::get('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'show'])
            ->name('admin.products.show');

        // UPDATE
        Route::put('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])
            ->name('admin.products.update');

        // DELETE
        Route::delete('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])
            ->name('admin.products.destroy');

    });

    // Route tambahan lain (kategori, pesanan dll tetap pakai view sementara)
    Route::get('/admin/categories', function () {
        return view('admin.categories.index');
    })->name('admin.categories.index');

    Route::get('/admin/orders', function () {
        return view('admin.orders.index');
    })->name('admin.orders.index');

    Route::get('/admin/orders/pending', function () {
        return view('admin.orders.pending');
    })->name('admin.orders.pending');

    Route::get('/admin/customers', function () {
        return view('admin.customers.index');
    })->name('admin.customers.index');

    Route::get('/admin/reports/sales', function () {
        return view('admin.reports.sales');
    })->name('admin.reports.sales');

    Route::get('/admin/reports/inventory', function () {
        return view('admin.reports.inventory');
    })->name('admin.reports.inventory');

    Route::get('/admin/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
});

// ✅ Halaman USER (khusus user)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user', function () {
        return view('user');
    })->name('user.dashboard');
});

// ✅ Halaman profil (bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Route bawaan auth (login/register)
require __DIR__.'/auth.php';