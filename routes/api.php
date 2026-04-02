<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('users', UserController::class)
        ->parameter('user', 'userId');
    Route::apiResource('channels', ChannelController::class)
        ->parameter('channel', 'channelId');

    Route::get('permissions', [PermissionController::class, 'index']);
});

