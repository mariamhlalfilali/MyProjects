<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\ReservationController;

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::apiResource('hotels', HotelController::class)->only(['index','show']);
    Route::apiResource('rooms', RoomController::class)->only(['index','show']);

    Route::get('/hotels/{hotel}/rooms', [RoomController::class, 'index']); 

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('reservations', ReservationController::class);
        Route::apiResource('hotels', HotelController::class)->except(['index','show']);
        Route::apiResource('rooms', RoomController::class)->except(['index','show']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
