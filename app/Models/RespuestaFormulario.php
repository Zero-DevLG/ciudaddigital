<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaFormulario extends Model
{
    use HasFactory;

    protected $table = 'respuestas_formulario';

    protected $fillable = [
        'instancia_tramite_id', 'campo_pasos_id', 'tipo',
        'valor_texto', 'valor_opcion', 'valor_entero', 'valor_decimal',
        'valor_booleano', 'valor_fecha', 'archivo_ruta',
    ];

    public function instancia()
    {
        return $this->belongsTo(InstanciaTramite::class, 'instancia_tramite_id');
    }

    public function campo()
    {
        return $this->belongsTo(CampoPaso::class, 'campo_pasos_id');
    }
}
