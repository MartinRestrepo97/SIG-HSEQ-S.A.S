<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
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
                    'certificado_id' => $certificado->id,
                    'curso' => $certificado->curso,
                    'fecha_emision' => $certificado->fecha_emision,
                    'fecha_expiracion' => $certificado->fecha_expiracion,
                    'norma_cumplida' => $certificado->norma_cumplida,
                    'estado' => $certificado->estado,
                    'documento_pdf' => $certificado->documento_pdf,
                    'fecha_inicio_validez' => $certificado->pivot->fecha_inicio_validez,
                    'fecha_fin_validez' => $certificado->pivot->fecha_fin_validez,
                ];
            })
        ], 200);
    }

}
