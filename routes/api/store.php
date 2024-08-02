<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;


Route::get('/store/inventory', [App\Http\Controllers\StoreController::class, 'getInventoryByStatus']);
Route::post('/store/order', [App\Http\Controllers\StoreController::class, 'placeOrder']);
Route::get('/store/order/find_purchase', [App\Http\Controllers\StoreController::class, 'find_purchase']);
Route::delete('/store/order/delete', [App\Http\Controllers\StoreController::class, 'delete_order']);
