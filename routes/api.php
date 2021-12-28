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


/**Rota para o Login */
Route::post('auth/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware(['apiJWT'])->group(function () {
    /** Informações do usuário logado */
    Route::get('auth/me', [\App\Http\Controllers\AuthController::class, 'me']);
    /** Encerra o acesso */
    Route::get('auth/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    /** Atualiza o token */
    Route::get('auth/refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    /** Listagem dos usuarios cadastrados, este rota serve de teste para verificar a proteção feita pelo jwt */
    Route::get('/users', [\App\Http\Controllers\AuthController::class, 'index']);
    Route::post('pagamento', [\App\Http\Controllers\PaymentController::class, 'pay'])->middleware('throttle:limit-request');


    Route::post('produto', [\App\Http\Controllers\ProductController::class, 'create']);
    Route::put('produto/{id}', [\App\Http\Controllers\ProductController::class, 'update']);
    Route::delete('produto/{id}', [\App\Http\Controllers\ProductController::class, 'destroy']);
    Route::get('produto/{id}', [\App\Http\Controllers\ProductController::class, 'show']);
    Route::get('produto', [\App\Http\Controllers\ProductController::class, 'index']);
});
