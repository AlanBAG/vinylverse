<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artista extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'pais',
        'genero',
        'biografia',
        'estado'
    ];
    public function vinilos()
    {
        return $this->hasMany(Vinilo::class);

    }
}
