<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentosTramite extends Model
{
    use SoftDeletes;

    protected $table = 'documentos_tramites';

    protected $fillable = [
        'tramite_id',
        'nombre_documento',
        'url',
        'tipo_documento_id',
    ];

    public function tramite()
    {
       return $this->belongsTo(TramiteC::class, 'tramite_id')
        ->whereNull('deleted_at');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(CatalogoDocumentos::class, 'tipo_documento_id');
    }
}
