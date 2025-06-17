<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/products');

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['verified'])->group(function () {
        // Produtos
        Route::apiResource('products', ProductController::class)->except('update');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::get('/product/status/{product}', [ProductController::class, 'status'])->name('status');
        Route::post('/product/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/product-images/{product}', [ProductController::class, 'deleteImage'])->name('product.deleteImage');
        Route::get('/products/getStatusList', [ProductController::class, 'status-list'])->name('status.list');
    });
});

require __DIR__ . '/auth.php';
