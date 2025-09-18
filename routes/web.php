<?php

use App\Http\Controllers\signatureController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\departmentController;
use App\Http\Controllers\rekomendasiController;

Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [App\Http\Controllers\userController::class, 'login']);
Route::get('/home', function () {
    return view('home');
});

//Route::get('/print-rekomendasi', [rekomendasiController::class, 'index'])->name('rekomendasi.index');
//REKOMENDASI
Route::post('/add_rekomendasi', [rekomendasiController::class, 'create'])->name('rekomendasi.create');
Route::get('/add_rekomendasi', [rekomendasiController::class, 'index'])->name('rekomendasi.index');
Route::get('/daftar_rekomendasi', [rekomendasiController::class, 'tampilData']);
Route::get('/report', [rekomendasiController::class, 'laporan'])->name('report');
Route::delete('/rekomendasi/{id_rek}', [rekomendasiController::class, 'destroy'])->name('rekomendasi.destroy');
Route::get('/rekomendasi/{id_rek}/edit', [rekomendasiController::class, 'edit'])->name('rekomendasi.edit');
Route::put('/rekomendasi/{id_rek}', [rekomendasiController::class, 'update'])->name('rekomendasi.update');
Route::get('search', [rekomendasiController::class, 'searchRekomendasi'])->name('searchRekomendasi');
Route::get('/print/{id}', [rekomendasiController::class, 'print'])->name('rekomendasi.print');


// // SIGNATURE
Route::get('/signature', [signatureController::class, 'index'])->name('signature.index');
Route::post('/signature', [signatureController::class, 'create'])->name('signature.create');
Route::delete('/signature/{id}', [signatureController::class, 'destroy'])->name('signature.destroy');
Route::get('/signature/{id}/edit', [signatureController::class, 'edit'])->name('signature.edit');
Route::put('/signature/{id}', [signatureController::class, 'update'])->name('signature.update');

// departmentController
Route::get('/department', [departmentController::class, 'index'])->name('department.index');
Route::post('/department', [departmentController::class, 'create'])->name('department.create');
Route::get('/department/{kode_dep}/edit', [departmentController::class, 'edit'])->name('department.edit');
Route::put('/department/{kode_dep}', [departmentController::class, 'update'])->name('department.update');
Route::delete('/department/{kode_dep}', [departmentController::class, 'destroy'])->name('department.destroy');
