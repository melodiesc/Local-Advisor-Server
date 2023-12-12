<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\OwnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchController;

Route::post('/register_user', [RegisterController::class, 'store']);
Route::post('/register_owner', [OwnerController::class, 'store']);
Route::get('/locations', [LocationController::class, 'index']);
Route::post('/{category}', [SearchController::class, 'search']);
Route::get('/{id}', [LocationController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
