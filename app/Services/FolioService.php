<?php

namespace App\Services;

use App\Models\FoliosContador;
use App\Models\TipoTramite;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class FolioService
{
    /**
     * Genera un folio único basado en tipo de trámite, fecha y consecutivo.
     *
     * @param int $tipoTramiteId
     * @param Carbon|null $fecha
     * @return string
     * @throws Exception
     */

    public function gerarFolio(int $tipoTramiteId, ?Carbon $fecha = null): string{


        //Obtenemos la fecha
        $fecha = $fecha ?? Carbon::now();

        //Obtiene el tipo de tramite

        $tipo_tramite = TipoTramite::where('id', $tipoTramiteId)->first();

        if(!$tipo_tramite){
            throw new Exception('Tipo de trámite no encontrado');
        }

        $codigo = strtoupper($tipo_tramite->code ?? substr($tipo_tramite->nombre, 0, 3));

        return DB::transaction(function () use ($tipo_tramite, $codigo, $fecha) {
            $contador = FoliosContador::firstOrCreate(
                ['tipo_tramite_id' => $tipo_tramite->id],
                ['ultimo_consecutivo' => 0 ]
            );

            // Incrementa el último consecutivo
            $contador->ultimo_consecutivo++;
            $contador->save();

            // Formatea fecha y consecutivo
            $fechaFormateada = $fecha->format('Ymd');
            $consecutivoFormateado = str_pad($contador->ultimo_consecutivo, 4, '0', STR_PAD_LEFT);

            //Construir el folio
            return "{$codigo}-{$fechaFormateada}-{$consecutivoFormateado}";


        });



    }


}
