<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CertificadosClientes;

class Certificados extends Model
{
    use HasFactory;

    protected $table = 'certificados';

    protected $fillable = [
        'curso',
        'fecha_inicio',
        'fecha_fin', 
        'norma_cumplida',
        'estado',
        'documento_pdf'
    ];
    

    /**
         * Un certificado puede estar asociado a varios clientes
         * a través de la tabla pivote certificados_clientes.
         */
    public function clientes()
    {
        return $this->belongsToMany(Clientes::class, 'certificados_clientes', 'certificados_id', 'clientes_id')
                    ->withPivot('fecha_inicio_validez', 'fecha_fin_validez');
    }

     /**
     * Un certificado puede aparecer múltiples veces
     * en la tabla pivote (asignado varias veces a uno o más clientes).
     */
    public function certificadosClientes()
    {
        return $this->hasMany(CertificadosClientes::class, 'certificados_id');
    }
}
