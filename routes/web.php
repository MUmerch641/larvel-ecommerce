<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductTableController;
use App\Http\Controllers\Admin\OrderTableController;
use App\Http\Controllers\Admin\OrderItemTableController;
use App\Http\Controllers\Admin\UserTableController;
use App\Http\Controllers\Admin\AdminTableController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;

Route::get('/', HomeController::class);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);

Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/items', [CartController::class, 'store']);
Route::patch('/cart/items/{cartItem}', [CartController::class, 'update']);
Route::delete('/cart/items/{cartItem}', [CartController::class, 'destroy']);

Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout', [CheckoutController::class, 'store']);

Route::get('/orders/{order_number}/thank-you', [OrderController::class, 'thankYou']);

Route::middleware('auth')->prefix('account')->group(function () {
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order_number}', [OrderController::class, 'show']);
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', LogoutController::class)->middleware('auth');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', AdminDashboardController::class);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::get('orders', [AdminOrderController::class, 'index']);
    Route::get('orders/{order}', [AdminOrderController::class, 'show']);
    Route::patch('orders/{order}', [AdminOrderController::class, 'update']);
    
    // DataTables routes
    Route::get('products-table', [ProductTableController::class, 'index'])->name('admin.products-table');
    Route::get('orders-table', [OrderTableController::class, 'index'])->name('admin.orders-table');
    Route::get('order-items-table', [OrderItemTableController::class, 'index'])->name('admin.order-items-table');
    Route::get('users-table', [UserTableController::class, 'index'])->name('admin.users-table');
    Route::get('admins-table', [AdminTableController::class, 'index'])->name('admin.admins-table');
});

