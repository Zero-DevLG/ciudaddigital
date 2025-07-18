<?php

namespace App\Http\Controllers;

use App\Services\PrevencionService;
use Illuminate\Http\Request;

class PrevencionController extends Controller
{
    //
    protected $prevencionService;

    public $tramiteId;
    public $pasoId;
    public $es_valido = 0;
    public $observaciones = '';


    public function __construct(PrevencionService $prevencionService)
    {
        $this->prevencionService = $prevencionService;
    }

    public function guardarPrevencion(Request $request)
    {
        $this->tramiteId = $request->input('tramite_id');
        $this->pasoId = $request->input('paso_id');
        $this->es_valido = $request->input('es_valido', 0);
        $this->observaciones = $request->input('observaciones', '');


        // Guardar la prevención utilizando el servicio
        $prevencion = $this->prevencionService->guardarPrevencion(
            $this->tramiteId,
            $this->pasoId,
            $this->es_valido,
            $this->observaciones
        );



        // Retornar una respuesta adecuada
        return response()->json([
            'message' => 'Prevención guardada correctamente.',
            'prevencion' => $prevencion,
        ]);



    }


    public function obtenerPrevencion(Request $request){

        $this->tramiteId = $request->input('tramite_id');
        $this->pasoId = $request->input('paso_id');

        // Obtener la prevención utilizando el servicio
        $prevencion = $this->prevencionService->obtenerPrevencion($this->tramiteId, $this->pasoId);

        if ($prevencion) {
            return response()->json([
                'message' => 'Prevención encontrada.',
                'prevencion' => $prevencion,
            ]);
        } else {
            return response()->json([
                'message' => 'No se encontró ninguna prevención para este trámite y paso.',
            ], 404);
        }

    }



}
