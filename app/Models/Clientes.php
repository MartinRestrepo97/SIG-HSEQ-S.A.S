<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'apellido',
        'cedula', 
        'email', 
        'telefono', 
        'codigo'
    ];

    // Relación muchos a muchos con Certificados
    public function certificados()
    {
        return $this->belongsToMany(Certificados::class, 'certificados_clientes')
            ->withPivot('fecha_certificacion')
            ->withTimestamps();
    }
}
