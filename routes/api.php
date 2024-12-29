<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CertificadosController;
use App\Http\Controllers\Api\ClientesController;

Route::get('/certificados', [CertificadosController::class, 'index']);
Route::post('/certificados', [CertificadosController::class, 'store']);
Route::get('/certificados/{id}', [CertificadosController::class, 'show']);
Route::put('/certificados/{id}', [CertificadosController::class, 'update']);
Route::delete('/certificados/{id}', [CertificadosController::class, 'destroy']);

Route::get('/clientes', [ClientesController::class, 'index']);
Route::post('/clientes', [ClientesController::class, 'store']);
Route::get('/clientes/{id}', [ClientesController::class, 'show']);
Route::put('/clientes/{id}', [ClientesController::class, 'update']);
Route::delete('/clientes/{id}', [ClientesController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
