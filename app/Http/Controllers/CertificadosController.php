<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\Clientes;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadosController extends Controller
{
    public function descargarCertificados($cliente_id, $certificado_id)
    {
        $cliente = Clientes::findOrFail($cliente_id);
        $certificado = Certificados::findOrFail($certificado_id);

        $pdf = Pdf::loadView('certificados.pdf', compact('clientes', 'certificados'));

        return $pdf->download('certificados.pdf');
    }
}
