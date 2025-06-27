<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TramiteC extends Model
{
    //

    protected $table = 'tramites_c';

    protected $fillable = [
        'folio',
        'tipo_tramite_id',
        'cat_estatus_id',
        'tramite_inicio',
        'tramite_termino',
    ];

    protected $dates = [
        'tramite_inicio',
        'tramite_termino',
        'deleted_at',
    ];

    // 🔗 Relación con TipoTramite
    public function tipoTramite()
    {
        return $this->belongsTo(TipoTramite::class, 'tipo_tramite_id');
    }

    // 🔗 Relación con CatalogoEstatus
    public function catalogoEstatus()
    {
        return $this->belongsTo(CatalogoEstatus::class, 'cat_estatus_id');
    }
}
