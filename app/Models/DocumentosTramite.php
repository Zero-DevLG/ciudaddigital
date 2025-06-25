<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentoTramite extends Model
{
    use SoftDeletes;

    protected $table = 'documentos_tramite';

    protected $fillable = [
        'tramite_id',
        'nombre_documento',
        'url',
        'tipo_documento_id',
    ];

    public function tramite()
    {
        return $this->belongsTo(TramiteC::class, 'tramite_id');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(CatalogoDocumentos::class, 'tipo_documento_id');
    }
}
