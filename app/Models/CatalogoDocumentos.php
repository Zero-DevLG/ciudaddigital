<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoDocumentos extends Model
{
    use SoftDeletes;

    protected $table = 'catalogo_documentos';

    protected $fillable = [
        'nombre_documento',
    ];
}
