<?php

use App\Http\Controllers\signatureController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [App\Http\Controllers\userController::class, 'login']);
Route::get('/home', function () {
    return view('home');
});


//REKOMENDASI
Route::get('/daftar_rekomendasi', function () {
    return view('daftar_rekomendasi', );
});
