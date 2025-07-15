<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoliosContador extends Model
{
    //
    protected $table = 'folios_contadores';

    protected $fillable = [
        'tipo_tramite_id',
        'ultimo_consecutivo',
    ];

    public $timestamps = true;

}
