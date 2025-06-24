<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Predio extends Model
{
    use SoftDeletes;

    protected $table = 'predios';

    protected $fillable = [
        'domicilio_id',
        'clave_catastral',
        'lat',
        'long',
        'superficie_total',
        'uso_actual_suelo_id',
        'tipo_propiedad_id',
        'uso_solicitado_id',
        'acceso_vialidades',
        'zona_urbana',
    ];

    // Relaciones (opcional, si las necesitas)
    // public function domicilio()
    // {
    //     return $this->belongsTo(Domicilio::class);
    // }

    // public function usoActual()
    // {
    //     return $this->belongsTo(CatalogoUsoSuelo::class, 'uso_actual_suelo_id');
    // }

    // public function usoSolicitado()
    // {
    //     return $this->belongsTo(CatalogoUsoSuelo::class, 'uso_solicitado_id');
    // }

    // public function tipoPropiedad()
    // {
    //     return $this->belongsTo(CatalogoPropiedad::class, 'tipo_propiedad_id');
    // }
}
