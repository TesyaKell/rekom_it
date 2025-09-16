<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
});

Route::get('/home', function () {
    return view('home');
});


Route::get('/daftar_rekomendasi', function () {
    return view('daftar_rekomendasi');
});
Route::get('/add_rekomendasi', function () {
    return view('add_rekomendasi');
});
Route::get('/department', function () {
    return view('department');
});
