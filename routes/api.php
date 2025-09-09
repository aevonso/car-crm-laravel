<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    // ИСПОЛЬЗУЕМ JWT MIDDLEWARE
    Route::middleware('jwt.auth')->group(function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

// Маршруты для автомобилей - ТОЖЕ используем JWT
Route::middleware('jwt.auth')->group(function () {
    Route::get('/available-cars', [CarController::class, 'getAvailableCars']);
});



Route::get('/debug-token', function (Request $request) {
    try {
        $token = $request->bearerToken();
        $user = \Tymon\JWTAuth\Facades\JWTAuth::setToken($token)->authenticate();
        
        return response()->json([
            'valid' => true,
            'user' => $user,
            'token' => $token
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'valid' => false,
            'error' => $e->getMessage(),
            'token' => $request->bearerToken()
        ], 401);
    }
});