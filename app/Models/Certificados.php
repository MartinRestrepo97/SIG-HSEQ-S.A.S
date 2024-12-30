<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificados extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso',
        'fecha_emision',
        'fecha_expiracion', 
        'norma_cumplida',
        'estado',
        'documento_pdf'
    ];

    // Relación muchos a muchos con Clientes
    public function clientes()
    {
        return $this->belongsToMany(Clientes::class, 'certificados_clientes')
            ->withPivot('fecha_certificacion')
            ->withTimestamps();
    }
}
