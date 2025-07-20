<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoCargo extends Model
{
    use SoftDeletes;

    protected $table = 'catalogo_cargo';

    protected $fillable = [
        'nombre_cargo',
        'active',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'cargo_users', 'cargo_id', 'user_id');
    }
}
