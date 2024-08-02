<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::post('/pet/uploadImage', [PetController::class, 'uploadImage']);
Route::post('/pet', [PetController::class, 'store']);
Route::put('/pet/update', [PetController::class, 'update_put']);
Route::get('/pet/findByStatus', [PetController::class, 'findByStatus']);
Route::get('/pet/get', [PetController::class, 'findById']);
Route::delete('/pet/delete', [PetController::class, 'delete']);
Route::post('/pet/update', [PetController::class, 'update']);
