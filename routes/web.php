<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Admin
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductController;

// User Cart & Checkout
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;

// Model
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD UMUM (optional)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin', function () {
        return view('admin.admin');
    })->name('admin.dashboard');

    Route::prefix('admin')->group(function () {

        // CRUD Produk
        Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
        Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/products/{id}', [ProductController::class, 'show'])->name('admin.products.show');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        // Inventory
        Route::get('/inventory', [InventoryController::class, 'index'])->name('admin.inventory.index');
        Route::post('/inventory/{product}/adjust', [InventoryController::class, 'adjust'])->name('admin.inventory.adjust');
    });

    Route::get('/admin/categories', fn () => view('admin.categories.index'))->name('admin.categories.index');
    Route::get('/admin/orders', fn () => view('admin.orders.index'))->name('admin.orders.index');
    Route::get('/admin/orders/pending', fn () => view('admin.orders.pending'))->name('admin.orders.pending');
    Route::get('/admin/customers', fn () => view('admin.customers.index'))->name('admin.customers.index');
    Route::get('/admin/reports/sales', fn () => view('admin.reports.sales'))->name('admin.reports.sales');
    Route::get('/admin/reports/inventory', fn () => view('admin.reports.inventory'))->name('admin.reports.inventory');
    Route::get('/admin/settings', fn () => view('admin.settings'))->name('admin.settings');
});

/*
|--------------------------------------------------------------------------
| USER AREA (Kasir)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {

    // Halaman User (produk)
    Route::get('/user', function () {
        $products = Product::orderBy('name')->paginate(12);
        return view('user', compact('products'));
    })->name('user.dashboard');

    // CART / KERANJANG
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // CHECKOUT KASIR / POS
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // PAYMENT SUCCESS (HALAMAN BERHASIL)
    Route::get('/payment/success', function () {
        if (!session()->has('payment')) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada data pembayaran.');
        }
        return view('payment');
    })->name('payment.success');
});

/*
|--------------------------------------------------------------------------
| PROFILE (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
