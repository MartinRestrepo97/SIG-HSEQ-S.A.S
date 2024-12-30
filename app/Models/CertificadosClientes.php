<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class CertificadosClientes extends Model
{
    protected $fillable = [
        'clientes_id',
        'certificados_id',
        'fecha_certificacion',
    ];

    // Relación con el modelo Cliente
    public function clientes(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'clientes_id');
    }

    // Relación con el modelo Certificado
    public function certificados(): BelongsTo
    {
        return $this->belongsTo(Certificados::class, 'certificados_id');
    }
}