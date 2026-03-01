<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Customer Routes (logged in users)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [CustomerController::class, 'index'])->name('home');
    Route::get('/products/{product}', [CustomerController::class, 'show'])->name('customer.products.show');
    Route::post('/orders', [CustomerController::class, 'order'])->name('customer.order');
    Route::get('/my-orders', [CustomerController::class, 'myOrders'])->name('customer.orders');
    Route::get('/order-confirmation/{order}', [CustomerController::class, 'confirmation'])->name('customer.order.confirmation');
    Route::patch('/orders/{order}/cancel', [CustomerController::class, 'cancelOrder'])->name('customer.order.cancel');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
});

require __DIR__ . '/auth.php';
