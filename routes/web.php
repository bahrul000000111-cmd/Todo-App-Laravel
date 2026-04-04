<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Routes (TANPA CSRF & WEB MIDDLEWARE)
Route::post('api/register', function () {
    return app()->make(\App\Http\Controllers\Api\AuthController::class)->register(request());
})->withoutMiddleware(['web', 'csrf']);

Route::post('api/login', function () {
    return app()->make(\App\Http\Controllers\Api\AuthController::class)->login(request());
})->withoutMiddleware(['web', 'csrf']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('api/logout', function () {
        return app()->make(\App\Http\Controllers\Api\AuthController::class)->logout(request());
    })->withoutMiddleware(['web', 'csrf']);

    Route::get('api/todos', function () {
        return app()->make(\App\Http\Controllers\Api\TodoController::class)->index(request());
    })->withoutMiddleware(['web', 'csrf']);

    Route::post('api/todos', function () {
        return app()->make(\App\Http\Controllers\Api\TodoController::class)->store(request());
    })->withoutMiddleware(['web', 'csrf']);

    Route::get('api/todos/{id}', function ($id) {
        return app()->make(\App\Http\Controllers\Api\TodoController::class)->show(request(), $id);
    })->withoutMiddleware(['web', 'csrf']);

    Route::put('api/todos/{id}', function ($id) {
        return app()->make(\App\Http\Controllers\Api\TodoController::class)->update(request(), $id);
    })->withoutMiddleware(['web', 'csrf']);

    Route::delete('api/todos/{id}', function ($id) {
        return app()->make(\App\Http\Controllers\Api\TodoController::class)->destroy(request(), $id);
    })->withoutMiddleware(['web', 'csrf']);

    Route::patch('api/todos/{id}/toggle', function ($id) {
    return app()->make(\App\Http\Controllers\Api\TodoController::class)->toggle(request(), $id);
    })->withoutMiddleware(['web', 'csrf']);

});