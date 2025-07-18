<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TramiteResoluciones extends Model
{
    use SoftDeletes;

    protected $table = 'tramite_resoluciones';

    protected $fillable = [
        'tramite_id',
        'documento_id',
        'tipo_resolucion_id',
    ];

    // Relaciones
    public function tramite()
    {
        return $this->belongsTo(TramiteC::class, 'tramite_id');
    }

    public function documento()
    {
        return $this->belongsTo(DocumentosTramite::class, 'documento_id');
    }

    public function tipoResolucion()
    {
        return $this->belongsTo(CatalogoResolucion::class, 'tipo_resolucion_id');
    }
}
