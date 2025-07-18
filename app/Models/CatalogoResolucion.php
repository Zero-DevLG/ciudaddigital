<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoResolucion extends Model
{
    protected $table = 'catalogo_resoluciones';

    protected $fillable = [
        'nombre',
    ];

    public function resoluciones()
    {
        return $this->hasMany(TramiteResolucion::class, 'tipo_resolucion_id');
    }
}
