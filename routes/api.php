<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('produto', [\App\Http\Controllers\ProductController::class, 'create']);
Route::put('produto/{id}', [\App\Http\Controllers\ProductController::class, 'update']);
Route::delete('produto/{id}', [\App\Http\Controllers\ProductController::class, 'destroy']);
Route::get('produto/{id}', [\App\Http\Controllers\ProductController::class, 'show']);
Route::get('produto', [\App\Http\Controllers\ProductController::class, 'index']);
