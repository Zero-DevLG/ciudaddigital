<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class CatalogoUsoSuelo extends Model
{


    protected $table = 'catalogo_uso_suelo';

    protected $fillable = [
        'tipo_uso',
    ];
}
