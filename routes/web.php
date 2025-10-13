<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\CursoController::class, 'getCursosForHome'])->name('home');

Route::prefix('auth')->group(function () {
    Route::get('login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [App\Http\Controllers\AuthController::class, 'auth']);
    Route::get('register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [App\Http\Controllers\AuthController::class, 'registerUser']);
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::post('google-login', [App\Http\Controllers\AuthController::class, 'googleLogin'])->name('auth.google');
});

Route::prefix('painel')->group(function () {
    Route::get('/', [App\Http\Controllers\PainelController::class, 'index'])->name('painel.index');
    Route::get('/users/{id}', [App\Http\Controllers\PainelController::class, 'show'])->name('painel.users.show');
    Route::get('/users/{id}/edit', [App\Http\Controllers\PainelController::class, 'edit'])->name('painel.users.edit');
    Route::put('/users/{id}', [App\Http\Controllers\PainelController::class, 'update'])->name('painel.users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\PainelController::class, 'destroy'])->name('painel.users.destroy');
});

// Rotas para CRUD de Cursos
Route::prefix('cursos')->group(function () {
    Route::get('/', [App\Http\Controllers\CursoController::class, 'index'])->name('cursos.index');
    Route::get('/create', [App\Http\Controllers\CursoController::class, 'create'])->name('cursos.create');
    Route::post('/', [App\Http\Controllers\CursoController::class, 'store'])->name('cursos.store');
    Route::get('/{id}', [App\Http\Controllers\CursoController::class, 'show'])->name('cursos.show');
    Route::get('/{id}/edit', [App\Http\Controllers\CursoController::class, 'edit'])->name('cursos.edit');
    Route::put('/{id}', [App\Http\Controllers\CursoController::class, 'update'])->name('cursos.update');
    Route::delete('/{id}', [App\Http\Controllers\CursoController::class, 'destroy'])->name('cursos.destroy');
});

Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');