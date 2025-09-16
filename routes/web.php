<?php

use App\Http\Controllers\signatureController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\departmentController;

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

Route::get('/report', [App\Http\Controllers\rekomendasiController::class, 'tampilData2'])->name('report');

Route::get('/signature', function () {
    return view('signature');
});

Route::get('/signature', [signatureController::class, 'index'])->name('signature.index');
Route::post('/signature', [signatureController::class, 'create'])->name('signature.create');

// departmentController
Route::get('/department', [departmentController::class, 'index'])->name('department.index');
Route::post('/department', [departmentController::class, 'create'])->name('department.create');
Route::get('/department/{id}/edit', [departmentController::class, 'edit'])->name('department.edit');
Route::put('/department/{id}', [departmentController::class, 'update'])->name('department.update');
Route::delete('/department/{id}', [departmentController::class, 'delete'])->name('department.delete');



