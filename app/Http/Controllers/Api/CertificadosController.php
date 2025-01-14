<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\Certificados;
use Illuminate\Http\Request;

class CertificadosController extends Controller
{
    public function index()
    {
        return Certificados::all();
    }

    public function store(Request $request)
    {
        return Certificados::create($request->all());
    }

    public function show($id)
    {
        return Certificados::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $certificado = Certificados::findOrFail($id);
        $certificado->update($request->all());
        return $certificado;
    }

    public function destroy($id)
    {
        Certificados::destroy($id);
        return response()->noContent();
    }

    public function testMartin($documentoCliente)
    {
        $cliente = Clientes::where('cedula', $documentoCliente)
            ->with('certificados')
            ->first();

        // Si no se encuentra el cliente, retornamos algún tipo de respuesta
        if (!$cliente) {
            return response()->json([
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        return $cliente;

        // Retornamos la información del cliente y sus certificados
        return response()->json([
            'cliente'     => $cliente,
            'certificados' => $cliente->certificadosCliente->map(function($pivot) {
                return [
                    'certificado_id'        => $pivot->certificado_id,
                    'curso'                 => $pivot->certificados->curso,
                    'fecha_inicio'          => $pivot->certificados->fecha_inicio,
                    'fecha_fin'             => $pivot->certificados->fecha_fin,
                    'norma_cumplida'        => $pivot->certificados->norma_cumplida,
                    'estado'                => $pivot->certificados->estado,
                    'documento_pdf'         => $pivot->certificados->documento_pdf,
                    'fecha_inicio_validez'  => $pivot->fecha_inicio_validez,
                    'fecha_fin_validez'     => $pivot->fecha_fin_validez,
                    'documento_pdf_validez' => $pivot->documento_pdf_validez,
                    'estado_validez'        => $pivot->estado_validez,
                ];
            })
        ], 200);
      return Clientes::where('cedula', $documentoCliente)->firstOrFail();      
    }

    public function descargarCertificados($clientesId, $certificadosId)
    {
        $certificado = Certificados::findOrFail($certificadosId);

        // Verifica que el certificado pertenezca al cliente
        if ($certificado->cliente_id != $clientesId) {
            return response()->json(['message' => 'Certificado no encontrado para este cliente'], 404);
        }

        // Ruta al archivo PDF
        $pathToFile = storage_path('app/' . $certificado->documento_pdf);

        // Verifica si el archivo existe
        if (!file_exists($pathToFile)) {
            return response()->json(['message' => 'Archivo no encontrado'], 404);
        }

        // Devuelve el archivo como una respuesta de descarga
        return response()->download($pathToFile, 'certificado_' . $certificadosId . '.pdf');
    }
}
