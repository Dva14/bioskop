<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua route di sini otomatis memakai prefix /api
| Contoh: http://localhost:8000/api/login
|--------------------------------------------------------------------------
*/

// =======================
// AUTH (PUBLIC)
// =======================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// =======================
// AUTH (JWT PROTECTED)
// =======================
Route::middleware('jwt.auth')->group(function () {
    Route::middleware('jwt.auth')->group(function () {
    Route::get('/films', [FilmController::class, 'index']);
    Route::post('/films', [FilmController::class, 'store']);
    });

Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('studios', StudioController::class);
});




Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('schedules', ScheduleController::class);
});



Route::middleware('jwt.auth')->group(function () {
    Route::apiResource('bookings', BookingController::class)
         ->only(['index', 'store', 'show', 'destroy']);
});




    // User info
    Route::get('/profile', [AuthController::class, 'profile']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Route berikut nanti untuk CRUD
    |--------------------------------------------------------------------------
    | films, studios, schedules, bookings
    | semuanya akan pakai JWT
    */
});

