<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampoPaso extends Model
{
    use HasFactory;

    protected $table = 'campo_pasos';

    protected $fillable = [
        'pasos_tramite_id',
        'nombre_campo',
        'tipo',
        'requerido',
        'opciones',
    ];

    protected $casts = [
        'requerido' => 'boolean',
        'opciones' => 'array', // para que se maneje como array automáticamente
    ];

    // Relación: un campo pertenece a un paso
    public function paso()
    {
        return $this->belongsTo(PasosTramite::class, 'pasos_tramite_id');
    }
}
