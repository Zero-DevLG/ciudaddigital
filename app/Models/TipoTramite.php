<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTramite extends Model
{


    protected $table = 'tipos_tramite';

    protected $fillable = ['nombre'];
}
