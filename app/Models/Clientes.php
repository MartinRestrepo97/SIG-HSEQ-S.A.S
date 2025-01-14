<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CertificadosClientes;

class Clientes extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre', 
        'apellido',
        'cedula', 
        'correo', 
        'telefono', 
        'codigo',
    ];

    /**
     * Relación con la tabla pivote certificados_clientes.
     */
    public function certificados()
    {
        return $this->hasMany(CertificadosClientes::class, 'clientes_id');
    } 

}
