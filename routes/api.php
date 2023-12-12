<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// importer le controller register
use App\Http\Controllers\RegisterController;
use Laravel\Sanctum\Http\Controllers\AuthenticatedSessionController;
use Laravel\Sanctum\Http\Controllers\RegisteredUserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route pour l'inscription //
Route::post('/register', [RegisterController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/', [ProductController::class, 'index']);
//     Route::post('/register', [ProductController::class, 'store']);
// });

// Route::post('/login', [AuthenticatedSessionController::class, 'store']);
// Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);