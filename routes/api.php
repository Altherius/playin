<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\CardReleaseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockItemController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreCreditHistoryController;
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

Route::post('/token', [ApiTokenController::class, 'token']);
Route::get('/me', [UserController::class, 'me'])->middleware('auth:sanctum');

Route::apiResource('addresses', AddressController::class)->only('show', 'update', 'destroy');
Route::apiResource('card-releases', CardReleaseController::class);
Route::apiResource('events', EventController::class)->except('destroy');
Route::apiResource('orders', OrderController::class)->except('destroy');
Route::apiResource('products', ProductController::class)->except('destroy');
Route::apiResource('registrations', RegistrationController::class);

Route::apiResource('stock-items', StockItemController::class)->only('store', 'update');
Route::apiResource('stocks', StockController::class)->except('destroy');
Route::post('/stocks/{stock}/addresses', [AddressController::class, 'addStockAddress']);

Route::apiResource('stores', StoreController::class)->except('destroy');
Route::get('stores/{store}/upcoming-events', [EventController::class, 'upcoming_events']);

Route::apiResource('users', UserController::class)->only('index', 'show', 'create');
Route::post('/users/{user}/addresses', [AddressController::class, 'addCustomerAddress']);

Route::apiResource('order-items', OrderItemController::class)->only('store', 'update');
Route::post('/orders/{order}/addresses', [AddressController::class, 'addOrderAddress']);

Route::apiResource('store-credit-histories', StoreCreditHistoryController::class)->only('index', 'show');
Route::get('/users/{user}/store-credit-history', [StoreCreditHistoryController::class, 'forUser']);
