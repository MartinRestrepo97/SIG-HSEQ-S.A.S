<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CertificadosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/certificados/{clientesId}/{certificadosId}/descargar', 
    [CertificadosController::class, 
        'descargarCertificados'])->name('certificados.descargar');

Route::get('/', function () {

});

Route::get('/constultar/{clientesId}', [CertificadosController::class, 
'testMartin']);
