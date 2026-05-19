<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'productIndex'])->name('dashboard');
    Route::get('/products', [ProductController::class, 'productIndex'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'productCreate'])->name('products.create');
    Route::post('/products', [ProductController::class, 'productStore'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'productEdit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'productUpdate'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'productDestroy'])->name('products.destroy');

    Route::get('/transactions', [TransactionController::class, 'transactionIndex'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionController::class, 'transactionCreate'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'transactionStore'])->name('transactions.store');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'transactionEdit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'transactionUpdate'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'transactionDestroy'])->name('transactions.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
