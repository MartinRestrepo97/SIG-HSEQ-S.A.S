<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CertificadosController;
use App\Http\Controllers\Api\ClientesController;

Route::get(
        '/descargar-certificado-cliente/{id}',
        [ClientesController::class, 'donwloadCertificadoCliente']
    );

Route::get('/', function () {
    // Otras rutas
});

Route::get('/constultar/{clientesId}', [CertificadosController::class, 
'testMartin']);
