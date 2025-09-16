<?php

use App\Http\Controllers\signatureController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\departmentController;

Route::post('/login', [App\Http\Controllers\userController::class, 'login']);

Route::get('/homee', function () {
    return view('homee');
});

Route::get('/daftar_rekomendasi', function () {
    return view('daftar_rekomendasi');
});

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
