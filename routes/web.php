<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

// Home
Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');


// Login
Route::prefix('login')->controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->middleware('guest')->name('login');
    Route::post('/', 'authenticate');
    Route::get('logout', 'logout')->name('logout');
});


// Pinjam
Route::middleware('auth')->controller(PinjamController::class)->group(function () {
    Route::get('pinjam', 'pinjam')->name('pinjam');
    Route::get('kembali', 'kembali')->name('kembali');
    Route::get('riwayat', 'riwayat')->name('riwayat');
    Route::post('pinjam.store', 'store')->name('pinjam.store');
    Route::delete('pinjam.delete/{pinjam}', 'delete')->name('pinjam.delete');
});


// Siswa
Route::middleware('auth')->prefix('siswa')->name('siswa')->controller(StudentController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('edit/{student}', 'edit')->name('.edit');
    Route::get('assigne/{student}', 'assigne')->name('.assigne');
    Route::get('create', 'create')->name('.create');
    Route::post('store', 'store')->name('.store');
    Route::patch('update', 'update')->name('.update');
    Route::delete('destroy/{student}', 'destroy')->name('.destroy');

    Route::patch('link', 'link')->name('.link');
    Route::patch('unlink/{device}', 'unlink')->name('.unlink');

    Route::get('disable', 'disable')->name('.disable');
    Route::patch('block/{student}', 'block')->name('.block');
    Route::patch('unblock/{student}', 'unblock')->name('.unblock');
});


// Devices
Route::middleware('auth')->prefix('device')->name('device')->controller(DeviceController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('edit/{device}', 'edit')->name('.edit');
    Route::get('create', 'create')->name('.create');
    Route::post('store', 'store')->name('.store');
    Route::patch('update', 'update')->name('.update');
    Route::delete('destroy/{device}', 'destroy')->name('.destroy');
});


// User
Route::middleware(['auth', 'level'])->prefix('user')->name('user')->controller(UserController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('create', 'create')->name('.create');
    Route::get('edit/{user}', 'edit')->name('.edit');
    Route::post('store', 'store')->name('.store');
    Route::patch('update', 'update')->name('.update');
    Route::delete('destroy/{user}', 'destroy')->name('.destroy');
});


// Rak
Route::middleware(['auth', 'level'])->prefix('rak')->name('rak')->controller(RakController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('assigne/{rak}', 'assigne')->name('.assigne');
    Route::post('store', 'store')->name('.store');
    Route::patch('update', 'update')->name('.update');
    Route::delete('destroy/{rak}', 'destroy')->name('.destroy');

    Route::patch('link', 'link')->name('.link');
    Route::patch('unlink/{device}', 'unlink')->name('.unlink');
});

// Fallback
Route::fallback(fn () => redirect()->route('home'));
