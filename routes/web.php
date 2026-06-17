<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController; // Adjust namespace if I didn't change folder
// Actually I put it in App\Http\Controllers\Auth\AuthController
use App\Http\Controllers\Buyer\HomeController;
use App\Http\Controllers\Buyer\CartController;
use App\Http\Controllers\Buyer\OrderController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Admin\DashboardController;

// Auth Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{product}', [HomeController::class, 'show'])->name('product.show');
Route::get('/category/{category}', [HomeController::class, 'category'])->name('category.show');

// Buyer Routes
Route::middleware(['auth', 'role:buyer'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'process'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Seller Routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->as('seller.')->group(function () {
    Route::get('/dashboard', function() { return redirect()->route('seller.products.index'); })->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::get('/orders', [ProductController::class, 'orders'])->name('orders.index');
    Route::post('/orders/{order}/confirm', [ProductController::class, 'confirmOrder'])->name('orders.confirm');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [DashboardController::class, 'users'])->name('users.index');
    Route::delete('/users/{user}', [DashboardController::class, 'deleteUser'])->name('users.destroy');
    Route::get('/products', [DashboardController::class, 'products'])->name('products.index');
    Route::delete('/products/{product}', [DashboardController::class, 'deleteProduct'])->name('products.destroy');
    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders.index');
    Route::post('/orders/{order}/update', [DashboardController::class, 'updateOrderStatus'])->name('orders.update');
    Route::get('/categories', [DashboardController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [DashboardController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{category}', [DashboardController::class, 'deleteCategory'])->name('categories.destroy');
});

// Temporary Route to Setup/Migrate Database on Railway
Route::get('/setup-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);
        return '<pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Temporary Route to Debug Database Configuration
Route::get('/debug-db', function () {
    return [
        'connection' => config('database.default'),
        'host' => config('database.connections.mysql.host'),
        'port' => config('database.connections.mysql.port'),
        'database' => config('database.connections.mysql.database'),
        'username' => config('database.connections.mysql.username'),
        'password' => config('database.connections.mysql.password') ? 'SET' : 'NOT_SET',
    ];
});

// Temporary Route to Link Storage
Route::get('/link-storage', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return '<pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});