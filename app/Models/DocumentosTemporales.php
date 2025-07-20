<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentosTemporales extends Model
{
    //
    protected $table = 'documentos_temporales';

    protected $fillable = [
        'tramite_id',
        'nombre_archivo',
        'url',
        'tipo_documento',
    ];


    public function tramite()
    {
        return $this->belongsTo(TramiteC::class, 'tramite_id');
    }



}
