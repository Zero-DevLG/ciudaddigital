<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasosTramite extends Model
{


    protected $table = 'pasos_tramite';

    protected $fillable = [
        'tramite_formato_id',
        'titulo_paso',
        'descripcion',
        'orden',
        'estatus',
    ];

    // Relación: Un paso pertenece a un formato de trámite
    public function tramiteFormato()
    {
        return $this->belongsTo(TramiteFormato::class, 'tramite_formato_id');
    }
}
