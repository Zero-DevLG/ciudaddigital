<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class CatalogoImpacto extends Model
{
    //


    protected $table = 'catalogo_impactos';

    protected $fillable = [
        'impacto',
    ];
}
