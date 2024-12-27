<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class CertificadosClientes extends Model
{
    protected $fillable = [
        'cliente_id',
        'certificado_id',
        'fecha_certificacion',
    ];

    // Relación con el modelo Cliente
    public function clientes(): BelongsTo
    {
        return $this->belongsTo(clientes::class, 'cliente_id');
    }

    // Relación con el modelo Certificado
    public function certificados(): BelongsTo
    {
        return $this->belongsTo(certificados::class, 'certificado_id');
    }
}