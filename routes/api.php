<?php

use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\AktorController;
use App\Http\Controllers\Api\FilmController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// route::get('kategori', [KategoriController::class, 'index']);
// route::get('kategori', [KategoriController::class, 'index']);
// route::post('kategori', [KategoriController::class, 'store']);
// route::get('kategori/{id}', [KategoriController::class, 'show']);
// route::put('kategori/{id}', [KategoriController::class, 'update']);
// route::delete('kategori/{id}', [KategoriController::class, 'delete']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('kategori', KategoriController::class);
    Route::resource('genre', GenreController::class);
    Route::resource('aktor', AktorController::class);
    Route::resource('film', FilmController::class);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
