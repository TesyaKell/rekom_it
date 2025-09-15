<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::post('/login', [App\Http\Controllers\userController::class, 'login']);

Route::get('/homee', function () {
    return view('homee');
});
