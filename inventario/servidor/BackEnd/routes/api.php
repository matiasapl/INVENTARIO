<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/usuarios/register', [AuthController::class, 'register']);
Route::post('/usuarios/login', [AuthController::class, 'login']);

// Grupo de rutas protegidas con middleware de JWT
Route::middleware('auth:api')->group(function () {
    Route::patch('/usuarios/change-password', [AuthController::class, 'changePassword']);
});