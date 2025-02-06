<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CertificadosController;

Route::get('/certificados', [CertificadosController::class, 'index']);

Route::get('/certificados/{id}', [CertificadosController::class, 'show']);

Route::apiResource('certificados', CertificadosController::class);

Route::get('certificados/download/{id}', [CertificadosController::class, 'download']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/constultar/{clientesId}', [CertificadosController::class, 
'testMartin']);
