<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user/get', [App\Http\Controllers\UserController::class, 'getUserByUsername']);
Route::post('/user/create_with_list', [App\Http\Controllers\UserController::class, 'createUserWithList']);


Route::middleware('auth')->group(function () {
    Route::post('/user/create', [App\Http\Controllers\UserController::class, 'createUser']);
    Route::put('/user/update', [App\Http\Controllers\UserController::class, 'updateUserByUsername']);
    Route::delete('/user/delete', [App\Http\Controllers\UserController::class, 'deleteUserByUsername']);
});
