<?php

use App\Http\Controllers\AdapterController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:login');

Route::middleware('auth:sanctum')->group(function () {
    /** AUTH ROUTES */
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    /** USERS ROUTES */
    Route::apiResource('users', UserController::class)
        ->parameter('user', 'userId');
    Route::post('users/{userId}/avatar', [UserController::class, 'updateAvatar']);
    Route::put('users/{userId}/password', [UserController::class, 'changePassword']);

    /** CHANNELS ROUTES */
    Route::apiResource('channels', ChannelController::class)
        ->parameter('channel', 'channelId');
    Route::patch('channels/{channelId}/status', [ChannelController::class, 'updateStatus']);

    /** CONVERSATION ROUTES */
    Route::apiResource('conversations', ConversationController::class)
        ->parameter('conversation', 'conversationId');

    /** MESSAGES ROUTES */
    Route::get('conversations/{conversationId}/messages', [MessageController::class, 'index']);

    /** PERMISSIONS ROUTES */
    Route::get('permissions', [PermissionController::class, 'index']);

    /** ADAPTERS ROUTES */
    Route::get('adapters', [AdapterController::class, 'index']);
});

