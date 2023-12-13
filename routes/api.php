<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\OwnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LoginController;

Route::post('/register_user', [RegisterController::class, 'store']);
Route::post('/register_owner', [OwnerController::class, 'store']);
Route::get('/locations', [LocationController::class, 'index']);
Route::post('/{category}', [SearchController::class, 'search']);
Route::get('/{id}', [LocationController::class, 'show']);
Route::post('/login', [LoginController::class, 'store']);
Route::post('/check-owner-email', 'OwnerController@checkOwnerEmail');
// Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
