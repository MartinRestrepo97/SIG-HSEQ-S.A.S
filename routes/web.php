<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CertificadosController;


Route::get('/certificados/{clientesId}/{certificadosId}', 
    [CertificadosController::class, 'descargarCertificados']);

Route::get('/', function () {
    // Otras rutas
});

Route::get('/constultar/{clientesId}', [CertificadosController::class, 
'testMartin']);
