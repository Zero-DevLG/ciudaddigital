<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;


class CatalogoPropiedad extends Model
{

    protected $table = 'catalogo_tipo_propiedad';

    protected $fillable = [
        'tipo_propiedad',
    ];
}
