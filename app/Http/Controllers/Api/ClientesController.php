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

}
