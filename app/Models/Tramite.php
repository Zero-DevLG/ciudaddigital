<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tramite extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'code',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Relaciones futuras (ejemplo)
    // public function pasos()
    // {
    //     return $this->hasMany(Paso::class);
    // }

    // public function instancias()
    // {
    //     return $this->hasMany(InstanciaTramite::class);
    // }

    // public function reglasDependencia()
    // {
    //     return $this->hasMany(TramiteDependencia::class, 'tramite_id');
    // }

    public function formatos()
    {
        return $this->hasMany(TramiteFormato::class, 'tramite_id');
    }


    public function dependencias()
    {
        return $this->belongsToMany(
            Tramite::class,
            'tramite_dependencias',
            'tramite_id',
            'tramite_requerido_id'
        );
    }

    // public function reglasEspeciales()
    // {
    //     return $this->hasMany(ReglaTramite::class);
    // }
}
