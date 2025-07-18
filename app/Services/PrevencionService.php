<?php

namespace App\Services;

use App\Models\PrevencionesTramite;
use Illuminate\Support\Facades\Auth;


class PrevencionService
{
    public function guardarPrevencion($tramiteId, $pasoId, $esValido, $observaciones)
    {
        // Validar los datos antes de guardarlos
        if (!in_array($esValido, [0, 1])) {
            throw new \InvalidArgumentException('El valor de es_valido debe ser 0 o 1.');
        }



        // Guardar la prevención en la base de datos
        $prevencion =  PrevencionesTramite::updateOrCreate(
            [
                'tramite_id' => $tramiteId,
                'catalogo_paso_id' => $pasoId,
            ],
            [
                'es_valido' => $esValido,
                'observaciones' => $observaciones,
                'verificador_id' => Auth::id(),
            ]
        );



        return $prevencion;
    }


    public function obtenerPrevencion($tramiteId, $pasoId)
    {
        // Obtener la prevención existente para el trámite y paso específicos
        return PrevencionesTramite::where('tramite_id', $tramiteId)
            ->where('catalogo_paso_id', $pasoId)
            ->first();
    }
}

