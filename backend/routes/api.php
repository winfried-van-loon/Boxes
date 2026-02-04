<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BoxController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\UserConnectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Box management
    Route::apiResource('boxes', BoxController::class);
    Route::post('boxes/{box}/photos', [BoxController::class, 'uploadPhoto']);
    Route::delete('boxes/{box}/photos/{photo}', [BoxController::class, 'deletePhoto']);
    Route::post('boxes/{box}/items', [BoxController::class, 'addItem']);
    Route::put('boxes/{box}/items/{item}', [BoxController::class, 'updateItem']);
    Route::delete('boxes/{box}/items/{item}', [BoxController::class, 'deleteItem']);

    // Room management
    Route::apiResource('rooms', RoomController::class);

    // User connections
    Route::prefix('connections')->group(function () {
        Route::get('/', [UserConnectionController::class, 'index']);
        Route::post('/generate-qr', [UserConnectionController::class, 'generateQrCode']);
        Route::post('/connect', [UserConnectionController::class, 'connect']);
        Route::post('/{connection}/accept', [UserConnectionController::class, 'accept']);
        Route::post('/{connection}/reject', [UserConnectionController::class, 'reject']);
        Route::delete('/{connection}', [UserConnectionController::class, 'destroy']);
    });
});

