<?php

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
Route::get('/add_rekomendasi', function () {
    return view('add_rekomendasi');
});

Route::post('/add_rekomendasi', [App\Http\Controllers\rekomendasiController::class, 'create']);
Route::get('/add_rekomendasi', [App\Http\Controllers\rekomendasiController::class, 'create']);
Route::get('/daftar_rekomendasi', [App\Http\Controllers\rekomendasiController::class, 'tampilData']);
