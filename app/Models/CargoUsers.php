<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CargoUsers extends Model
{
    use SoftDeletes;

    protected $table = 'cargo_users';

    protected $fillable = [
        'user_id',
        'cargo_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cargo()
    {
        return $this->belongsTo(CatalogoCargo::class, 'cargo_id');
    }
}
