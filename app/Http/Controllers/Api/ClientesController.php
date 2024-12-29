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
        return Clientes::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $certificado = Clientes::findOrFail($id);
        $certificado->update($request->all());
        return $certificado;
    }

    public function destroy($id)
    {
        Clientes::destroy($id);
        return response()->noContent();
    }
}
