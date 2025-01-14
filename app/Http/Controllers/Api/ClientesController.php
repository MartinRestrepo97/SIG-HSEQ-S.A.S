<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\CertificadosClientes;

use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function index()
    {
        return Clientes::all(); 
    }

    public function store(Request $request)
    {
        return Clientes::create($request->all());
    }

    public function show($id)
    {
        return Clientes::with('certificados')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $cliente = Clientes::findOrFail($id);
        $cliente->update($request->all());
        return $cliente;
    }

    public function destroy($id)
    {
        Clientes::destroy($id);
        return response()->noContent();
    }

    public function donwloadCertificadoCliente($id)
    {
        $certificado = CertificadosClientes::findOrFail($id);
        $auxAsset = asset('storage/' . $certificado->documento_pdf_validez);

        $auxAsset2 = app('url')->asset("storage/".$certificado->documento_pdf_validez);
        // $archivoPdf = public_path($auxAsset);
        // echo $auxAsset2;

        $archivoPdf = public_path('storage/' . $certificado->documento_pdf_validez);
        echo $archivoPdf;
        if (!file_exists($archivoPdf)) {            
            echo "no existe";
            // abort(404, 'El archivo no se encuentra disponible eeeeeeee.');
        }

        return response()->download($archivoPdf);

    }

    public function getClienteByCedula($cedula)
    {
        // Buscamos al cliente por la cédula y cargamos los certificados directamente
        $cliente = Clientes::where('cedula', $cedula)
            ->with('certificados')
            ->first();

        // Si no se encuentra el cliente, retornamos un error
        if (!$cliente) {
            return response()->json([
                'message' => 'Cliente no encontrado'
            ], 404);
        }

        // Retornamos la información del cliente y sus certificados
        return response()->json([
            'cliente' => $cliente,
            'certificados' => $cliente->certificados->map(function ($certificado) {
                return [
                    'certificado_id'        => $certificado->id,
                    'curso'                 => $certificados->curso,
                    'fecha_inicio'          => $certificados->fecha_inicio,
                    'fecha_fin'             => $certificados->fecha_fin,
                    'norma_cumplida'        => $certificados->norma_cumplida,
                    'estado'                => $certificados->estado,
                    'documento_pdf'         => $certificados->documento_pdf,
                    'fecha_inicio_validez'  => $certificados->pivot->fecha_inicio_validez,
                    'fecha_fin_validez'     => $certificados->pivot->fecha_fin_validez,
                    'documento_pdf_validez' => $certificados->pivot->documento_pdf_validez,
                    'estado_validez'        => $certificados->pivot->estado_validez,
                ];
            })
        ], 200);
    }

}
