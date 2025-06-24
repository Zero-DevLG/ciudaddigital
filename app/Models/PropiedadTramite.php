<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropiedadTramite extends Model
{
    use SoftDeletes;

    protected $table = 'propiedad_tramite';

    protected $fillable = [
        'propiedad_id',
        'tramite_id',
    ];

    // Relaciones
    public function predio()
    {
        return $this->belongsTo(Predio::class, 'propiedad_id');
    }

    public function tramite()
    {
        return $this->belongsTo(TramiteC::class, 'tramite_id');
    }
}
