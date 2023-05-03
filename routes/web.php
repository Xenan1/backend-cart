<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::redirect('/', '/products/');

Route::get('/products/', [\App\Http\Controllers\ProductController::class, 'index']);
Route::post('/products/add_cart/{product}', [\App\Http\Controllers\ProductController::class, 'store']);

Route::get('/cart/', [\App\Http\Controllers\CartController::class, 'index']);
Route::get('/cart/clear/', [\App\Http\Controllers\CartController::class, 'clear']);
Route::post('/cart/remove_cart/{product}', [\App\Http\Controllers\CartController::class, 'delete']);

