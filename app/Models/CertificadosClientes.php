<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class CertificadosClientes extends Model
{
    use HasFactory;

    protected $table = 'certificados_clientes';

    protected $fillable = [
        'clientes_id',
        'certificados_id',
        'fecha_inicio_validez',
        'fecha_fin_validez',
        'documento_pdf_validez',
        'estado_validez',
    ];

    /**
     * Relación con el modelo Clientes
     */
    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id');
    }

    /**
     * Relación con el modelo Certificados
     */
    public function certificados()
    {
        return $this->belongsTo(Certificados::class, 'certificados_id');
    }
}