<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::prefix('auth')->group(function () {
    Route::get('login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [App\Http\Controllers\AuthController::class, 'auth']);
    Route::get('register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [App\Http\Controllers\AuthController::class, 'registerUser']);
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});

Route::prefix('painel')->group(function () {
    Route::get('/', [App\Http\Controllers\PainelController::class, 'index'])->name('painel.index');
    Route::get('/users/{id}', [App\Http\Controllers\PainelController::class, 'show'])->name('painel.users.show');
    Route::get('/users/{id}/edit', [App\Http\Controllers\PainelController::class, 'edit'])->name('painel.users.edit');
    Route::put('/users/{id}', [App\Http\Controllers\PainelController::class, 'update'])->name('painel.users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\PainelController::class, 'destroy'])->name('painel.users.destroy');
});

Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');