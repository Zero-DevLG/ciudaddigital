<?php

namespace App\Http\Controllers;

use App\Models\CatalogoEstatus;
use App\Models\TipoTramite;
use App\Models\TramiteC;
use App\Models\CatalogoPasosTramite;
use App\Models\TramiteProyecto;
use Illuminate\Http\Request;
use App\Models\DocumentosTramite;
use App\Models\TramitePersona;
use App\Models\PropiedadTramite;
use App\Models\TramiteUsuario;
use App\Services\DocumentoService;
use App\Services\FechaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\CatalogoDocumentos;
use App\Models\DocumentosTemporales;
use App\Models\PrevencionesTramite;
use App\Models\Tramite;
use App\Services\PDFService;
use App\Services\QrCodeService;
use App\Services\FolioService;
use Carbon\Carbon;
use Dom\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Traits\HasRoles;
use App\Models\TramiteResoluciones;
use App\Models\User;

class TramitesController extends Controller
{

     public $tramiteId;
    public $persona;
    public $predio;
    public $domicilio_predio;
    public $tipo_propiedad;
    public $uso_suelo_actual;
    public $uso_suelo_solicitado;
    public $tramite_proyecto;
    public $impacto_estimado;
    public $tipo_construccion;
    public $car_proyecto;
    public $plano_documento;
    public $estudio_impacto_documento;
    public $documentos_tramite;
    public $PDFService;
    public $documentoService;

    public function __construct(PDFService $PDFService, DocumentoService $documentoService)
    {

        $this->documentoService = $documentoService;

        $this->PDFService = $PDFService;

    }

    public function iniciar($id)
    {
        // Buscar el trámite por ID
        $tramite_tipo = TipoTramite::findOrFail($id);
        #dd($tramite);
        // Si es tipo 1, mostrar el componente Livewire 'tramite_uso_suelo'
        if ($tramite_tipo->id == 1) {


            //creat tramite

            $tramite = TramiteC::create([
                'folio' => null,
                'tipo_tramite_id' => $tramite_tipo->id,
                'cat_estatus_id' => 1,
                'tramite_inicio' => now(),
                'tramite_termino' => null,
                'created_at' => now()
            ]);

            //Crear tramite usuario
            TramiteUsuario::create([
                'tramite_id' => $tramite->id,
                'usuario_id' => Auth::user()->id,
                'role' => 'solicitante',
                'view' => false, // Inicialmente no se ha visto
            ]);


            // Crear puntero de pasos

            $pasos_puntero = CatalogoPasosTramite::where('tipo_tramite_id', $tramite_tipo->id)
                ->orderBy('n_paso')
                ->get();




            // Redirige a la vista del trámite creado, pasando el id
            return redirect()->route('tramites.uso_suelo', ['tramite' => $tramite->id]);
        }
        // ...puedes agregar más condiciones para otros tipos aquí...
    }


    public function mostrarTramite(TramiteC $tramite)
    {



        $tramite_tipo = TipoTramite::findOrFail($tramite->tipo_tramite_id);

        // Trae los pasos para ese tipo de trámite
        $pasos_puntero = CatalogoPasosTramite::where('tipo_tramite_id', $tramite_tipo->id)
            ->orderBy('n_paso')
            ->get();

        // Retorna la vista con los datos del trámite existente
        return view('tramites.tramite_uso_suelo', compact('tramite', 'tramite_tipo', 'pasos_puntero'));
    }

    public function validarTramite(TramiteC $tramite)
    {


        // Trae los pasos para ese tipo de trámite
        $tramite_tipo = TipoTramite::findOrFail($tramite->tipo_tramite_id);
        $pasos_puntero = CatalogoPasosTramite::where('tipo_tramite_id', $tramite_tipo->id)
            ->orderBy('n_paso')
            ->get();

        // Retorna la vista con los datos del trámite existente
        return view('tramites.validar_tramite', compact('tramite', 'tramite_tipo', 'pasos_puntero'));
    }

    public function generarPdf($id, PDFService $PDFService, QrCodeService $qrService, DocumentoService $documentoService , FolioService $folioService, FechaService $fechaService)
    {
        // Verificar si el trámite existe
        $tramite = TramiteC::findOrFail($id);



          $this->tramiteId = $id;

        //Obtenemos solicitante
        $persona_tramite = TramitePersona::where('tramite_id', $this->tramiteId)
            ->first();

        if($persona_tramite) {
            $this->persona = $persona_tramite->persona; // Asignamos la persona asociada al tramite
        } else {
            $this->persona = null; // O maneja el caso donde no se encuentra la persona
        }

        //Obtener uinformacion predio
        $propiedad_tramite = PropiedadTramite::with('predio.domicilio', 'predio.tipoPropiedad', 'predio.usoActual', 'predio.usoSolicitado')->where('tramite_id', $this->tramiteId)
            ->first();



        if($propiedad_tramite) {
            $this->predio = $propiedad_tramite->predio; // Asignamos la propiedad asociada al tramite
            $this->domicilio_predio = $this->predio->domicilio;
            $this->tipo_propiedad = $this->predio->tipoPropiedad; // Asignamos el tipo de propiedad
            $this->uso_suelo_actual = $this->predio->usoActual; // Asignamos el uso actual del suelo
            $this->uso_suelo_solicitado = $this->predio->usoSolicitado; // Asignamos el uso solicitado del suelo




        } else {
            $this->predio = null; // O maneja el caso donde no se encuentra la propiedad
        }

        //Obtener características del proyecto
        $this->car_proyecto = TramiteProyecto::with('impactoEstimado', 'tipoConstruccion','planoDocumento','estudioImpactoDocumento')->where('tramite_id', $this->tramiteId)
            ->first();

        //dd($this->car_proyecto);


        if($this->car_proyecto) {
            $this->tramite_proyecto = $this->car_proyecto; // Asignamos las características del proyecto
            $this->impacto_estimado = $this->car_proyecto->impactoEstimado; // Asignamos el impacto estimado
            $this->tipo_construccion = $this->car_proyecto->tipoConstruccion; // Asignamos el tipo de construcción
            $this->plano_documento = $this->car_proyecto->planoDocumento; // Asignamos el documento del plano
            $this->estudio_impacto_documento = $this->car_proyecto->estudioImpactoDocumento; // Asignamos el documento del estudio de impacto

        } else {
            $this->tramite_proyecto = null; // O maneja el caso donde no se encuentra el proyecto
        }


        //obtener documentos tramite
        $this->documentos_tramite = DocumentosTramite::where('tramite_id', $this->tramiteId)
            ->get();





          // Generar el código QR para la ruta 'resumen-tramite/{id}'
        $qrBase64 = $qrService->generarQrBase64DesdeRuta('tramites.ver', ['id' => $id], 150);

         $tramites = DB::table('tramites_c as tc')
            ->leftJoin('tipos_tramite as tt', 'tc.tipo_tramite_id', '=', 'tt.id')
            ->leftJoin('catalogo_estatus as ce', 'tc.cat_estatus_id', '=', 'ce.id')
            ->where('tc.id', $this->tramiteId)
            ->select(
                'tc.id',
                'tc.folio',
                'tc.tipo_tramite_id',
                'tc.created_at',
                'tt.nombre as tipo_tramite_nombre',
                'tt.code as tipo_tramite_code',
                'ce.estado as catalogo_estatus_estado'
            )
            ->first();



        // Verificar si el trámite tiene un folio asignado
        if(!$tramite->folio) {
            $folio = $folioService->gerarFolio($tramites->tipo_tramite_id, Carbon::now());
        }else{
            $folio = $tramite->folio;
            //Prevencion
            $resolucion_prevencion_f2 = TramiteResoluciones::
            where('tramite_id',$tramite->id)
            ->where('tipo_resolucion',4)->first();

            if($resolucion_prevencion_f2){
                $resolucion_prevencion_f2->deleted_at = Carbon::now();
                $resolucion_prevencion_f2->save();
            }
        }


           $tramite_actual = TramiteC::findOrFail($this->tramiteId);

            //Obtener fecha termino (3 meses a partir de la fecha de inicio)
            $fecha_termino = $fechaService->sumarDiasHabiles(
                Carbon::now(),
                63 // 60 días hábiles
            );


        // Actualizar el folio del trámite
            $tramite_actual->folio = $folio;
            $tramite_actual->cat_estatus_id = 2; // Cambiar el estatus a "En Proceso"
            $tramite_actual->tramite_termino = $fecha_termino;
            $tramite_actual->updated_at = Carbon::now(); // Actualizar la fecha de actualización
            $tramite_actual->save();




         // Construir datos para el PDF
        $data = [
            'persona' => $this->persona,
            'tramite' => $tramites,
            'predio' => $this->predio,
            'domicilio_predio' => $this->domicilio_predio,
            'uso_suelo_actual' => $this->uso_suelo_actual,
            'uso_suelo_solicitado' => $this->uso_suelo_solicitado,
            'tipo_propiedad' => $this->tipo_propiedad,
            'tramite_proyecto' => $this->tramite_proyecto,
            'impacto_estimado' => $this->impacto_estimado,
            'tipo_construccion' => $this->tipo_construccion,
            'car_proyecto' => $this->car_proyecto,
            'plano_documento' => $this->plano_documento,
            'estudio_impacto_documento' => $this->estudio_impacto_documento,
            'documentos_tramite' => $this->documentos_tramite,
            'logo' => public_path('images/logo.png'),
            'folio' => $folio,
             'qrSvg' => $qrBase64,
             'tipo_documento' => '1',
        ];

         $file =  $PDFService->descargarResumenTramite($data, 'resumen_tramite_'.$this->tramiteId.'.pdf');


        // return view('tramites.resumen_tramite_final', [
        //     'file' => $file,
        //     'folio' => $folio,
        //     'tramite' => $tramites,
        // ]);

            return redirect()->route('tramites.resumen', ['id' => $this->tramiteId]);

    }


    public function mostrarResumen($id)
    {
        $tramite = TramiteC::findOrFail($id);
        $documento = DocumentosTramite::where('tramite_id', $id)
        ->where('tipo_documento_id', 1)
        ->first();

        if (!$documento) {
            abort(404, 'No se encontró el documento generado.');
        }

        return view('tramites.resumen_tramite_final', [
            'file' => $documento,
            'folio' => $tramite->folio,
            'tramite' => $tramite,
        ]);
    }


    public function verTramite($id)
{
    $tramite = TramiteC::findOrFail($id);

    //Obtener el estado del tramite
    $estatus_tramite = CatalogoEstatus::where('id', $tramite->cat_estatus_id)->first();


    // Obtener persona asociada al trámite
    $persona_tramite = TramitePersona::where('tramite_id', $id)->first();
    $persona = $persona_tramite?->persona;

    // Obtener predio y datos relacionados
    $propiedad_tramite = PropiedadTramite::with('predio.domicilio', 'predio.tipoPropiedad', 'predio.usoActual', 'predio.usoSolicitado')
        ->where('tramite_id', $id)
        ->first();

    $predio = $domicilio_predio = $tipo_propiedad = $uso_suelo_actual = $uso_suelo_solicitado = null;

    if ($propiedad_tramite && $propiedad_tramite->predio) {
        $predio = $propiedad_tramite->predio;
        $domicilio_predio = $predio->domicilio;
        $tipo_propiedad = $predio->tipoPropiedad;
        $uso_suelo_actual = $predio->usoActual;
        $uso_suelo_solicitado = $predio->usoSolicitado;
    }

    // Obtener características del proyecto
    $car_proyecto = TramiteProyecto::with('impactoEstimado', 'tipoConstruccion', 'planoDocumento', 'estudioImpactoDocumento')
        ->where('tramite_id', $id)
        ->first();

    $tramite_proyecto = $impacto_estimado = $tipo_construccion = $plano_documento = $estudio_impacto_documento = null;

    if ($car_proyecto) {
        $tramite_proyecto = $car_proyecto;
        $impacto_estimado = $car_proyecto->impactoEstimado;
        $tipo_construccion = $car_proyecto->tipoConstruccion;
        $plano_documento = $car_proyecto->planoDocumento;
        $estudio_impacto_documento = $car_proyecto->estudioImpactoDocumento;
    }

    // Documentos del trámite
    $documentos_tramite = DocumentosTramite::where('tramite_id', $id)->get();


    //Obtener historicos de resoluciones
    $resoluciones = TramiteResoluciones::where('tramite_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();



    //Verificar si existe una resolucion de prevencion

   $resolucion_prevencion = TramiteResoluciones::withTrashed()
    ->with([
        'tipoResolucion',
        'documento'
    ])
    ->where('tramite_id', $id)
    ->where('tipo_resolucion_id', 4)
    ->first();




    $tramite_pasos = PrevencionesTramite::with(['paso'])
        ->where('tramite_id', $id)
        ->orderBy('catalogo_paso_id', 'asc')
        ->get();



    $datos_prevencion = [
        'tramite_id' => $id,
        'tipo_resolucion' => $resolucion_prevencion ? $resolucion_prevencion->tipoResolucion->nombre : 'No disponible',
        'tramite_pasos' => $tramite_pasos,
        'fecha_emision' => $resolucion_prevencion ? $resolucion_prevencion->fecha_emision : null,


    ];

    //Obtener tipo de usuario
    $tipo_usuario = User::where('id', Auth::id())->first();


    // dd($resolucion_prevencion,$datos_prevencion, $tramite_pasos);

    //Obtener acuse de solicitud
    $acuse_solicitud = DocumentosTramite::where('tramite_id', $id)
        ->where('tipo_documento_id', 1) // ID del tipo de documento para acuse de solicitud
        ->first();

    //Obtener resolucion

    $resolucion_f = TramiteResoluciones::with(['tipoResolucion', 'documento'])
        ->where('tramite_id', $id)
        ->where('tipo_resolucion_id', '!=', 4)
        ->first();



     // Oculta datos sensibles para la vista pública
    if (!Auth::user()) {
        if ($persona) {
            $persona->telefono = null;
            $persona->correo_electronico = null;
            $persona->curp = null;
        }
    }


    // Enviar todo a la vista
    return view('tramites.ver_tramite', compact(
        'tramite',
        'persona',
        'predio',
        'domicilio_predio',
        'tipo_propiedad',
        'uso_suelo_actual',
        'uso_suelo_solicitado',
        'tramite_proyecto',
        'impacto_estimado',
        'tipo_construccion',
        'plano_documento',
        'estudio_impacto_documento',
        'car_proyecto',
        'documentos_tramite',
        'estatus_tramite',
        'resoluciones',
        'datos_prevencion',
        'resolucion_prevencion',
        'resolucion_f',
        'acuse_solicitud',
        'tipo_usuario'
    ));
}



    public function misTramites()
    {
         $usuario = Auth::user();

          session(['pasoActual' => 0]);

        return view('user.tramites-usuario', compact('usuario'));
    }



    public function firmarResolucion(Request $request)
    {

        // Verifica que se recibió correctamente todo
        if (!$request->hasFile('cer') || !$request->hasFile('key') || !$request->input('password')) {
            return response()->json([
                'success' => false,
                'message' => 'Faltan archivos o contraseña'
            ]);
        }


            // Recuperar trámite y PDF
        $tramite = TramiteC::findOrFail($request->tramite_id);
        $tipoDocumento = CatalogoDocumentos::findOrFail(5);

        $documento = DocumentosTramite::where('tramite_id', $request->tramite_id)
        ->where('tipo_documento_id', 5) // Resolución
        ->latest()
        ->first();



        if (!$documento || !Storage::disk('public')->exists($documento->url)) {
            return response()->json(['success' => false, 'message' => 'Documento no encontrado']);
        }

        $pdfPath = Storage::disk('public')->path($documento->url);


        $tempPath = storage_path('app/temp-firma');
        if (!file_exists($tempPath)) mkdir($tempPath, 0777, true);

        // Guarda los archivos en disco
        $cerPath = $request->file('cer')->storeAs('temp-firma', 'firma.cer', 'local');
        $keyPath = $request->file('key')->storeAs('temp-firma', 'firma.key', 'local');

        $cerFullPath = storage_path('app/' . $cerPath);
        $keyFullPath = storage_path('app/' . $keyPath);

        $cer = $request->file('cer');
        $key = $request->file('key');

        $cerPath = $cer->storeAs('temp-firma', 'firma.cer');
        $keyPath = $key->storeAs('temp-firma', 'firma.key');

        // Verificación manual inmediata
        if (!Storage::exists($cerPath)) {
            dd("CER no guardado: $cerPath");
        }
        if (!Storage::exists($keyPath)) {
            dd("KEY no guardado: $keyPath");
        }

        $path = storage_path('app/temp-firma');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // dd([
        // 'hasCer' => $request->hasFile('cer'),
        // 'cerIsValid' => $request->file('cer')->isValid(),
        // 'hasKey' => $request->hasFile('key'),
        // 'keyIsValid' => $request->file('key')->isValid(),
        // ]);

        // dd('Archivos guardados correctamente', [
        // 'cerPath' => $cerPath,
        // 'keyPath' => $keyPath,
        // 'absolute_cer' => storage_path("app/$cerPath"),
        // 'absolute_key' => storage_path("app/$keyPath"),
        // ]);

        try {
        $request->file('cer')->move($path, 'firma.cer');
        $request->file('key')->move($path, 'firma.key');
        } catch (\Exception $e) {
            dd('Error al mover archivos', $e->getMessage());
        }


            $pdfFirmado = $this->PDFService->firmarResolucion(
                $pdfPath,
                storage_path('app/' . $cerPath),
                storage_path('app/' . $keyPath),
                $request->input('password')
            );

            $tempFilePath = storage_path('app/temp-firma/' . $documento->nombre_documento);
            file_put_contents($tempFilePath, $pdfFirmado);

            $uploadedFile = new UploadedFile(
                $tempFilePath,
                $documento->nombre_documento,
                'application/pdf',
                null,
                true
            );

            $nuevoDocumento = $this->documentoService->storeDocumento(
                $uploadedFile,
                $tramite->id,
                5,
                $documento->nombre_documento,
                'public'
            );

            dd($nuevoDocumento);

            return response($pdfFirmado, 200)->header('Content-Type', 'application/pdf');


    }


    public function obtenerResolucionTemporal(Request $request)
    {
        $tramiteId = $request->input('tramite_id');

        // Verificar si el trámite existe
        $tramite = TramiteC::findOrFail($tramiteId);

        // Obtener el documento de resolución temporal
        $documento = DocumentosTemporales::where('tramite_id', $tramiteId)
            ->where('tipo_documento', 5) // ID del tipo de documento de resolución
            ->first();

        if (!$documento) {
            return response()->json(['success' => false, 'message' => 'Documento no encontrado'], 404);
        }

        // Retornar la URL del documento
        return response()->json(['success' => true, 'url' => asset('storage/' . $documento->url)]);
    }


    public function finalizarVerificacion(Request $request)
    {
        $tramiteId = $request->input('tramite_id');
        $archivoFirmado = $request->file('archivo_firmado');


        try {

            DB::beginTransaction();


            //obtener si  existe una prevencion
            $resolucion_prevencion = TramiteResoluciones::withTrashed()
                ->with([
                    'tipoResolucion',
                    'documento'
                ])
                ->where('tramite_id', $tramiteId)
                ->where('tipo_resolucion_id', 4)
                ->first();

             $tramite_resolucion = TramiteResoluciones::where('tramite_id', $tramiteId)
            ->whereNull('deleted_at')
            ->first();

            //dd($resolucion_prevencion);

              // Verificar si el trámite existe

            if($tramite_resolucion->tipo_resolucion_id == 4){

                $tramite = TramiteC::findOrFail($tramiteId);
                $tramite->cat_estatus_id = 5;
                $tramite->save();
            }else{

            $tramite = TramiteC::findOrFail($tramiteId);
            $tramite->cat_estatus_id = 6;
            $tramite->save();
            }



            //Guardar documento en disco y DB


            if($tramite_resolucion->tipo_resolucion_id == 4){
                $tipoDocumento = 3;
                $nombre_tipo_documento = CatalogoDocumentos::findOrFail($tipoDocumento);
                $filename = strtoupper($nombre_tipo_documento->nombre_documento . '-' . 'PREVENCION-'   . $tramite->folio . '.pdf');
            }else{
                $tipoDocumento = 5;
                $nombre_tipo_documento = CatalogoDocumentos::findOrFail($tipoDocumento);
                $filename = strtoupper($nombre_tipo_documento->nombre_documento . '-'   . $tramite->folio . '.pdf');
            }


            $documentoResolucion = $this->documentoService->storeDocumento(
                $archivoFirmado,
                $tramiteId,
                $tipoDocumento,
                $filename,
                'public'
            );

            $tramite_resolucion->documento_id = $documentoResolucion->id;
            $tramite_resolucion->fecha_emision = Carbon::now();
            $tramite_resolucion->save();



            DB::commit();

            return response()->json(['success' => true, 'message' => 'Trámite verificado correctamente']);



        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al verificar el trámite: ' . $th->getMessage()], 500);
        }







        $tramiteResoulucionTemporal = TramiteResoluciones::where('tramite_id', $tramiteId)
            ->first();





        return response()->json(['success' => true, 'message' => 'Trámite verificado correctamente']);

    }







}
