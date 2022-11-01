<?php

use App\Http\Controllers\External\AttackApiController;
use App\Http\Controllers\External\CallApiController;
use App\Http\Controllers\External\ErrorApiController;
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

Route::prefix('/v1')->group(function () {
    Route::post('/chamados/novo', [CallApiController::class, 'store']);
    Route::post('/chamados/mensagens/nova', [CallApiController::class, 'receiveMessage']);

    Route::put('/erros', ErrorApiController::class);
    Route::put('/ataques', AttackApiController::class);
});
