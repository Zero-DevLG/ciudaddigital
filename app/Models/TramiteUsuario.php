<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TramiteUsuario extends Model
{
    use SoftDeletes;

    protected $table = 'tramite_usuario';

    protected $fillable = [
        'tramite_id',
        'usuario_id',
        'role',
        'view',
    ];

    // RELACIONES
    public function tramite()
    {
        return $this->belongsTo(TramiteC::class, 'tramite_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // SCOPES
    public function scopePorTramite($query, $tramiteId)
    {
        return $query->where('tramite_id', $tramiteId);
    }

    public function scopePorUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    // FUNCIONES AUXILIARES
    public static function asignarUsuario($tramiteId, $usuarioId, $role = 'solicitante')
    {
        return self::updateOrCreate(
            [
                'tramite_id' => $tramiteId,
                'usuario_id' => $usuarioId,
            ],
            [
                'role' => $role,
                'view' => false,
            ]
        );
    }
}
