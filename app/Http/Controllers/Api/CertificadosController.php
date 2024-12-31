<?php

namespace App\Http\Controllers\Api;

use App\Models\Certificado;
use App\Models\Clientes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadosController extends Controller
{
    public function index()
    {
        $certificados = Certificados::all();
        return response()->json($certificados);
    }

    public function show($id)
    {
        $certificado = Certificados::find($id);
        if ($certificado) {
            return response()->json($certificado);
        } else {
            return response()->json(['message' => 'Certificado no encontrado'], 404);
        }
    }

    public function download($id)
    {
        $certificado = Certificados::findOrFail($id);
        $pathToFile = storage_path('app/' . $certificado->documento_pdf);
        return response()->download($pathToFile);
    }
}
