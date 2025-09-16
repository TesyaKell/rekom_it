<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [App\Http\Controllers\userController::class, 'login']);

Route::get('/homee', function () {
    return view('homee');
});
Route::get('/department', function () {
    return view('department');
});
