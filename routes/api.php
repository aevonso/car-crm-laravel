<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware('jwt.auth')->group(function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/available-cars', [CarController::class, 'getAvailableCars']);
    
    Route::get('/cars', [CarController::class, 'index']);
    Route::get('/cars/{id}', [CarController::class, 'show']);
    Route::post('/cars', [CarController::class, 'store']);
    Route::put('/cars/{id}', [CarController::class, 'update']);
    Route::delete('/cars/{id}', [CarController::class, 'destroy']);
});