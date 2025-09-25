<?php

use App\Http\Controllers\detailRekomendasiController;
use App\Http\Controllers\JabatanController;
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


//REKOMENDASI
Route::get('/detailRekomendasi/{id_rek}', [rekomendasiController::class, 'tampilDetail'])->name('rekomendasi.detail');


Route::post('/add_rekomendasi', [rekomendasiController::class, 'create'])->name('rekomendasi.create');

Route::get('/add_rekomendasi', [rekomendasiController::class, 'index'])->name('rekomendasi.index');

Route::get('/deleted_rekomendasi', [rekomendasiController::class, 'tampilDataTerhapus'])->name('rekomendasi.deleted');
Route::post('/rekomendasi/{id_rek}/restore', [rekomendasiController::class, 'restore'])->name('rekomendasi.restore');
Route::get('/daftar_rekomendasi', [rekomendasiController::class, 'tampilData'])
    ->name('rekomendasi.daftar');
Route::get('/report', [rekomendasiController::class, 'laporan'])->name('report');
Route::delete('/rekomendasi/{id_rek}', [rekomendasiController::class, 'destroy'])->name('rekomendasi.destroy');


Route::get('/rekomendasi/{id_rek}/edit', [rekomendasiController::class, 'edit'])->name('rekomendasi.edit');

Route::put('/rekomendasi/{id_rek}', [rekomendasiController::class, 'update'])->name('rekomendasi.update');
Route::post('/rekomendasi/{id_rek}/approve', [rekomendasiController::class, 'updateStatus'])->name('rekomendasi.approve');

Route::get('search', [rekomendasiController::class, 'searchRekomendasi'])->name('searchRekomendasi');
Route::get('/print/{id}', [rekomendasiController::class, 'print'])->name('rekomendasi.print');


Route::get('/rekomendasi/filter', [RekomendasiController::class, 'filterStatus'])->name('rekomendasi.filter');


Route::post('/detail-rekomendasi/masukan/{id}', [App\Http\Controllers\DetailRekomendasiController::class, 'masukan'])->name('detailRekomendasi.masukan');

// Update detail rekomendasi
Route::put('/detail-rekomendasi/{id_detail_rekomendasi}', [App\Http\Controllers\detailRekomendasiController::class, 'update'])->name('detailRekomendasi.update');


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
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/login')->with('message', 'You have been logged out successfully.');
})->name('logout');


//JABATAN
Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan.index');
Route::post('/jabatan', [JabatanController::class, 'create'])->name('jabatan.create');
Route::delete('/jabatan/{id}', [JabatanController::class, 'destroy'])->name('jabatan.destroy');
Route::get('/jabatan/{id}/edit', [JabatanController::class, 'edit'])->name('jabatan.edit');
Route::put('/jabatan/{id}', [JabatanController::class, 'update'])->name('jabatan.update');
Route::put('/jabatan/{id}', [JabatanController::class, 'update'])->name('jabatan.update');


//Report
Route::get('/report/export', [rekomendasiController::class, 'export'])->name('report.export');
