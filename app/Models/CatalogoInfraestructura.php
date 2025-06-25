<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoInfraestructura extends Model
{
    use SoftDeletes;

    protected $table = 'catalogo_infraestructura';

    protected $fillable = ['infraestructura'];
}
