<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificados extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cedula',
        'codigo', 
        'descripcion',
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
