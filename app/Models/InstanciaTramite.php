<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstanciaTramite extends Model
{
    use HasFactory;

    protected $table = 'instancia_tramites';

    protected $fillable = [
        'user_id', 'tramite_id', 'tramite_formato_id', 'estatus', 'fecha_inicio', 'fecha_fin',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tramite()
    {
        return $this->belongsTo(Tramite::class);
    }

    public function formato()
    {
        return $this->belongsTo(TramiteFormato::class, 'tramite_formato_id');
    }

    public function respuestas()
    {
        return $this->hasMany(RespuestaFormulario::class);
    }
}
