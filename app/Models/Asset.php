<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    // Definimos los campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre_original',
        'ruta_almacenamiento',
        'tipo_mime',
    ];
}
