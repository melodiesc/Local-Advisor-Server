<?php

use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use Laravel\Sanctum\Http\Controllers\AuthenticatedSessionController;
use Laravel\Sanctum\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SearchController;

Route::post('/register', [RegisterController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/{category}', [SearchController::class, 'search']);
Route::get('/locations', [LocationController::class, 'index']);
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/', [ProductController::class, 'index']);
//     Route::post('/register', [ProductController::class, 'store']);
// });

// Route::post('/login', [AuthenticatedSessionController::class, 'store']);
// Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
