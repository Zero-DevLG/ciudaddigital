<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ValidacionPasoTramite extends Model
{
    use HasFactory;

    protected $table = 'validaciones_pasos_tramite';

    protected $fillable = [
        'tramite_id',
        'catalogo_paso_id',
        'es_valido',
        'observaciones',
        'verificador_id',
    ];

    // 🔗 Relaciones

    public function tramite()
    {
        return $this->belongsTo(TramiteC::class, 'tramite_id');
    }

    public function paso()
    {
        return $this->belongsTo(CatalogoPasosTramite::class, 'catalogo_paso_id');
    }

    public function verificador()
    {
        return $this->belongsTo(User::class, 'verificador_id');
    }
}
