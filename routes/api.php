<?php

use App\Enums\Permissions;
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
    Route::middleware(Permissions::VIEW_USER->toMiddleware())->get('users', [App\Http\Controllers\UserController::class, 'index']);
    Route::middleware(Permissions::VIEW_USER->toMiddleware())->get('users/{id}', [App\Http\Controllers\UserController::class, 'show']);

    //Teams resource routes
    Route::middleware(Permissions::VIEW_TEAM->toMiddleware())->get('teams', [App\Http\Controllers\TeamController::class, 'index']);
    Route::middleware(Permissions::VIEW_TEAM->toMiddleware())->get('teams/{id}', [App\Http\Controllers\TeamController::class, 'show']);
    Route::middleware(Permissions::CREATE_TEAM->toMiddleware())->post('teams', [App\Http\Controllers\TeamController::class, 'store']);
    Route::middleware(Permissions::EDIT_TEAM->toMiddleware())->put('teams/{id}', [App\Http\Controllers\TeamController::class, 'update']);
    Route::middleware(Permissions::DELETE_TEAM->toMiddleware())->delete('teams/{id}', [App\Http\Controllers\TeamController::class, 'destroy']);

    //Players resource routes
    Route::middleware(Permissions::VIEW_PLAYER->toMiddleware())->get('players', [App\Http\Controllers\PlayerController::class, 'index']);
    Route::middleware(Permissions::VIEW_PLAYER->toMiddleware())->get('players/{id}', [App\Http\Controllers\PlayerController::class, 'show']);
    Route::middleware(Permissions::CREATE_PLAYER->toMiddleware())->post('players', [App\Http\Controllers\PlayerController::class, 'store']);
    Route::middleware(Permissions::EDIT_PLAYER->toMiddleware())->put('players/{id}', [App\Http\Controllers\PlayerController::class, 'update']);
    Route::middleware(Permissions::DELETE_PLAYER->toMiddleware())->delete('players/{id}', [App\Http\Controllers\PlayerController::class, 'destroy']);

    //Games resource routes
    Route::middleware(Permissions::VIEW_GAME->toMiddleware())->get('games', [App\Http\Controllers\GameController::class, 'index']);
    Route::middleware(Permissions::VIEW_GAME->toMiddleware())->get('games/{id}', [App\Http\Controllers\GameController::class, 'show']);
    Route::middleware(Permissions::CREATE_GAME->toMiddleware())->post('games', [App\Http\Controllers\GameController::class, 'store']);
    Route::middleware(Permissions::EDIT_GAME->toMiddleware())->put('games/{id}', [App\Http\Controllers\GameController::class, 'update']);
    Route::middleware(Permissions::DELETE_GAME->toMiddleware())->delete('games/{id}', [App\Http\Controllers\GameController::class, 'destroy']);
});