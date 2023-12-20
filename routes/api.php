<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\OwnerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ResponseController;


Route::post('/create_card', [LocationController::class, 'store']);
Route::post('/register_user', [RegisterController::class, 'store']);
Route::post('/register_owner', [OwnerController::class, 'store']);
Route::get('/locations', [LocationController::class, 'index']);
Route::delete('/locations/{id}', [LocationController::class, 'destroy']);
Route::put('/locations/{id}', [LocationController::class, 'update']);
Route::post('/login', [LoginController::class, 'store'])->name('login');
Route::post('/password/reset-email', [PasswordResetController::class, 'sendResetEmail'])->name('password.reset');
Route::post('/categories/{category}', [SearchController::class, 'search']);
Route::post('/{id}/responses/store', [ResponseController::class, 'store']);
Route::get('/{id}/responses/show', [ResponseController::class, 'show']);
Route::post('/{id}/notices/store', [NoticeController::class, 'store']);
Route::get('/{id}/notices/show', [NoticeController::class, 'show']);
Route::get('/{id}', [LocationController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {return $request->user();});
    Route::get('/{userType}/profile', [ProfileController::class, 'index']);
    Route::put('/updateprofil/{userType}', [ProfileController::class, 'update']);
});