<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrevencionesTramite extends Model
{

     protected $table = 'prevenciones_tramite';

    protected $fillable = [
        'tramite_id',
        'catalogo_paso_id',
        'observaciones',
        'verificador_id',
        'es_valido',
    ];

    public function tramite()
    {
        return $this->belongsTo(Tramite::class, 'tramite_id');
    }

    public function paso()
    {
        return $this->belongsTo(CatalogoPasosTramite::class, 'catalogo_paso_id');
    }

    public function verificador()
    {
        return $this->belongsTo(User::class, 'verificador_id');
    }

}
