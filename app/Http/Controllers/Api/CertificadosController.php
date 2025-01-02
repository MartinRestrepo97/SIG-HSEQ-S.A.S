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
      $auxTest = ["ssss", "ssfdsfsdf"];
      return Clientes::where('cedula', $documentoCliente)->firstOrFail();
      // return $auxTest;
    }
}
