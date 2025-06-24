<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CatalogoPasosTramite extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catalogo_pasos_tramite';

    protected $fillable = [
        'tipo_tramite_id',
        'n_paso',
        'nombre_paso',
        'estatus',
    ];

    protected $casts = [
        'estatus' => 'boolean',
    ];

    // Relación con TipoTramite
    public function tipoTramite()
    {
        return $this->belongsTo(TipoTramite::class, 'tipo_tramite_id');
    }

    // Relación con TramiteC
    public function tramites()
    {
        return $this->hasMany(TramiteC::class, 'paso_tramite_id');
    }
}
