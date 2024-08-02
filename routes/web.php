<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::get('/', function () {
    return view('welcome');
});


require __DIR__.'/api/pet.php';
require __DIR__.'/api/store.php';
require __DIR__.'/api/user.php';
require __DIR__.'/api/auth.php';
