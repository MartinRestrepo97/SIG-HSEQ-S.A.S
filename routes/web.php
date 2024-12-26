<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificadoController;

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

Route::get('/certificados/{clienteId}/{certificadoId}/descargar', 
    [CertificadoController::class, 
        'descargarCertificado'])->name('certificados.descargar');

Route::get('/', function () {
    return view('welcome');
});
