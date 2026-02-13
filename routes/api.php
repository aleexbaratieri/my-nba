<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API']);
});

Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    //Auth Routes
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('/me', [App\Http\Controllers\AuthController::class, 'me']);

    //User resource routes
    Route::get('users', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('users/{id}', [App\Http\Controllers\UserController::class, 'show']);

    //Teams resource routes
    Route::apiResource('teams', App\Http\Controllers\TeamController::class);

    //Players resource routes
    Route::apiResource('players', App\Http\Controllers\PlayerController::class);
});