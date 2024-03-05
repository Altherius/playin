<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockItemController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('users', UserController::class)->only('index', 'show', 'create');
Route::apiResource('products', ProductController::class)->except('destroy');
Route::apiResource('stocks', StockController::class)->except('destroy');
Route::apiResource('orders', OrderController::class)->except('destroy');
Route::apiResource('stores', StoreController::class)->except('destroy');
Route::apiResource('stock-items', StockItemController::class)->only('store', 'update');
Route::apiResource('order-items', OrderItemController::class)->only('store', 'update');
