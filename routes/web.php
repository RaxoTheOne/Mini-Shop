<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Startseite
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Produkt anzeigen
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Produkte einer Kategorie anzeigen
Route::get('/categories/{slug}', [ProductController::class, 'category'])->name('products.category');

// Warenkorb
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Bestellungen
Route::get('/order', [OrderController::class, 'create'])->name('orders.create');
Route::post('/order', [OrderController::class, 'store'])->name('orders.store');
Route::get('/order/{id}', [OrderController::class, 'show'])->name('orders.show');