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
        'codigo'
    ];

    /**
     * Un cliente puede tener varios certificados asignados
     * a través de la tabla pivote certificado_cliente.
     */
    public function certificados()
    {
        return $this->belongsToMany(Certificados::class, 'certificados_clientes', 'clientes_id', 'certificados_id')
                    ->withPivot('fecha_inicio_validez', 'fecha_fin_validez');
    }

    /**
     * Relación con la tabla pivote certificados_clientes.
     */
    public function certificadosCliente()
    {
        return $this->hasMany(CertificadosClientes::class, 'clientes_id');
    }
}
