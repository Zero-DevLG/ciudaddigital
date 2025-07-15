<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TramiteProyecto extends Model
{
    use SoftDeletes;

    protected $table = 'tramite_proyecto';

    protected $fillable = [
         'tramite_id',
        'descripcion_general',
        'impacto_estimado_id',
        'tipo_construccion_id',
        'niveles',
        'infraestructura_seleccionada',
        'plano_documento_id',             // <-- AGREGA ESTE
        'estudio_impacto_documento_id',
    ];

    protected $casts = [
    'infraestructura_seleccionada' => 'array',
];

    // Relaciones
    public function tramite()
    {
        return $this->belongsTo(TramiteC::class);
    }

    public function impactoEstimado()
    {
        return $this->belongsTo(CatalogoImpacto::class, 'impacto_estimado_id');
    }

    public function tipoConstruccion()
    {
        return $this->belongsTo(CatalogoConstruccion::class, 'tipo_construccion_id');
    }

public function getInfraestructurasAttribute()
{
    return CatalogoInfraestructura::whereIn('id', $this->infraestructura_seleccionada ?? [])->get();
}

    public function planoDocumento()
{
    return $this->belongsTo(DocumentosTramite::class, 'plano_documento_id');
}

public function estudioImpactoDocumento()
{
    return $this->belongsTo(DocumentosTramite::class, 'estudio_impacto_documento_id');
}


}
