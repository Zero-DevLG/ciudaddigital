<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;


class CatalogoConstruccion extends Model
{

    protected $fillable = [
        'tipo_construccion',
    ];
}
