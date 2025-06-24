<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domicilios extends Model
{
    use SoftDeletes;

    protected $table = 'domicilios';

    protected $fillable = [
        'estado',
        'delegacion_municipio',
        'calle',
        'n_exterior',
        'n_interior',
        'cp',
    ];
}
