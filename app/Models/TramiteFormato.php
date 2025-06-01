<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TramiteFormato extends Model
{
    use HasFactory;

    protected $table = 'tramite_formato'; // ya que no sigue el plural por defecto

    protected $fillable = [
        'tramite_id',
        'nombre_formato',
        'descripcion',
    ];

    // Relación con Tramite
    public function tramite()
    {
        return $this->belongsTo(Tramite::class, 'tramite_id');
    }

    public function pasos()
    {
        return $this->hasMany(PasosTramite::class, 'tramite_formato_id');
    }

    public function instancias()
    {
        return $this->hasMany(InstanciaTramite::class);
    }


}
