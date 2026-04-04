<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoController;

// Set middleware manual
Route::middleware(['api'])->group(function () {

    // Public routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        
        Route::get('/todos', [TodoController::class, 'index']);
        Route::post('/todos', [TodoController::class, 'store']);
        Route::get('/todos/{id}', [TodoController::class, 'show']);
        Route::put('/todos/{id}', [TodoController::class, 'update']);
        Route::delete('/todos/{id}', [TodoController::class, 'destroy']);
        Route::patch('/todos/{id}/toggle', [TodoController::class, 'toggle']);
    });

});