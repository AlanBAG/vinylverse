<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vinilo extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'titulo',
        'genero',
        'anio_lanzamiento',
        'numero_canciones',
        'precio',
        'stock',
        'formato',
        'discografia',
        'descripcion',
        'imagen',
        'estado',
        'artista_id'
    ];

    public function artista()
    {
        return $this->belongsTo(Artista::class);
    }
}
