<?php

namespace App\Http\Controllers;

use App\Models\CargoUsers;
use App\Models\CatalogoResolucion;
use App\Models\PrevencionesTramite;
use App\Services\PDFService;
use App\Services\PrevencionService;
use Illuminate\Http\Request;
use App\Models\TramiteC;
use App\Models\User;
use App\Services\QrCodeService;
use Illuminate\Support\Facades\Auth;
use App\Models\TramiteResoluciones;


class PrevencionController extends Controller
{
    //
    protected $prevencionService;
    protected $PDFService;

    public $tramiteId;
    public $pasoId;
    public $es_valido = 0;
    public $observaciones = '';
    public $tipo_resolucion;
    public $motivo_resolucion;


    public function __construct(PrevencionService $prevencionService, PDFService $PDFService)
    {
        $this->prevencionService = $prevencionService;
        $this->PDFService = $PDFService;
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

    public function vistaPreviaResolucion(Request $request, QrCodeService $qrService)
    {
        $this->tramiteId = $request->input('tramite_id');

        $tramite = TramiteC::where('id', $this->tramiteId)->first();

        $this->tipo_resolucion = $request->input('tipo_resolucion');
        $this->motivo_resolucion = $request->input('motivo_resolucion');

        $tipo_resolucion = CatalogoResolucion::find($this->tipo_resolucion);

        //obtener persona firmante

        $persona_firmante = User::where('id', Auth::id())->first();

        $nombre_persona_firmante = $persona_firmante->name;

        //Cargo persona firmante
        $cargo_persona_firmante = CargoUsers::with('cargo')
        ->where('user_id', Auth::id())->first();

        $cargo = $cargo_persona_firmante->cargo;

        $qrSvg = $qrService->generarQrBase64DesdeRuta('resumen-tramite.show', ['id' => $tramite->id], 150);

        //Si es una prevencion, obtener las observaciones por pasos

        $pasos = PrevencionesTramite::with('paso')
        ->where('tramite_id', $tramite->id)
        ->orderBy('catalogo_paso_id', 'asc')
            ->get();



        $data = [
            'tramiteId' => $this->tramiteId,
            'tramite' => $tramite,
            'tipo_resolucion' => $tipo_resolucion->nombre,
            'motivo_resolucion' => $this->motivo_resolucion,
            'persona_firmante' => $nombre_persona_firmante,
            'cargo_persona_firmante' => $cargo ? $cargo->nombre_cargo : 'No disponible',
            'qrSvg' => $qrSvg,
            'pasos' => $pasos,
            'tipo_resolucion_id' => $tipo_resolucion->id,
        ];






        $url = $this->PDFService->generarPdfVistaPreviaResolucion($data);

        return response()->json([
            'success' => true,
            'message' => 'PDF generado correctamente',
            'url' => $url,
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


    public function obtenerResolucionPrevencionVerificador(Request $request)
    {
        $this->tramiteId = $request->input('tramite_id');

        $prevencion_resolucion = $this->prevencionService->obtenerResolucionPrevencionVerificador($this->tramiteId);

        return response()->json([
            'message' => 'Resolución de prevención obtenida correctamente.',
            'resolucion' => $prevencion_resolucion,
        ]);

    }



}
