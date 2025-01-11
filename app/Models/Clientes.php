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
    /* public function certificadosCliente()
    {
        return $this->hasMany(CertificadosClientes::class, 'clientes_id');
    }*/

    public function certificados()
    {
        return $this->belongsToMany(Certificados::class, 'certificados_clientes', 'clientes_id', 'certificados_id')
                    ->withPivot('fecha_inicio_validez', 'fecha_fin_validez', 'documento_pdf_validez');
    }
    
}
