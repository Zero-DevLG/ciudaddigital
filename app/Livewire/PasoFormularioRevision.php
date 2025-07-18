<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TramitePersona;
use App\Models\CatalogoPasosTramite;
use App\Models\TramiteC;
use App\Models\ValidacionPasoTramite;
use App\Models\PropiedadTramite;
use App\Models\TramiteProyecto;
use App\Models\DocumentosTramite;

class PasoFormularioRevision extends Component
{
    public $tramite_id;
    public $pasos_puntero;
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
    public $catalogo_paso_id;
    public $validacionPaso;

    public $es_valido = 1; // valor por defecto
    public $observaciones = '';
    public $mensajeExito = '';

    protected $listeners = ['actualizarValidez'];


    public function actualizarValidez($valor)
    {
        $this->es_valido = (int)$valor;
        dd($this->es_valido); // Para depuración, puedes eliminarlo después
    }


    public function guardarValidacion()
{

    dd('Guardando validación con es_valido: ' . $this->es_valido . ' y observaciones: ' . $this->observaciones);

    $this->validate([
        'es_valido' => 'required|in:0,1',
        'observaciones' => 'nullable|string|max:2000',
    ]);

    $validacion = \App\Models\ValidacionPasoTramite::updateOrCreate(
        [
            'tramite_id' => $this->tramite_id,
            'catalogo_paso_id' => $this->catalogo_paso_id,
        ],
        [
            'es_valido' => $this->es_valido,
            'observaciones' => $this->es_valido === '0' ? $this->observaciones : null,

        ]
    );

    $this->mensajeExito = 'Validación guardada correctamente.';
}

    public function mount($tramiteId, $nombrePaso)
    {
       # dd('Mounting PasoFormularioRevision with tramiteId: ' . $tramiteId . ' and nombrePaso: ' . $nombrePaso);

        $this->tramite_id = $tramiteId;
        $this->pasos_puntero = $nombrePaso;

        // Obtener datos del solicitante
        $persona_tramite = TramitePersona::where('tramite_id', $this->tramite_id)->first();
        $this->persona = $persona_tramite?->persona;

         $propiedad_tramite = PropiedadTramite::with('predio.domicilio', 'predio.tipoPropiedad', 'predio.usoActual', 'predio.usoSolicitado')->where('tramite_id', $this->tramite_id)
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



        //paso 3

         //Obtener características del proyecto
        $this->car_proyecto = TramiteProyecto::with('impactoEstimado', 'tipoConstruccion','planoDocumento','estudioImpactoDocumento')->where('tramite_id', $this->tramite_id)
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

        // Paso 4
             //obtener documentos tramite
        $this->documentos_tramite = DocumentosTramite::where('tramite_id', $this->tramite_id)
            ->get();


        // Obtener ID del paso desde la tabla catálogo
        $catalogoPaso = CatalogoPasosTramite::where('tipo_tramite_id', function ($query) use ($tramiteId) {
                $query->select('tipo_tramite_id')
                        ->from('tramites')
                        ->where('id', $tramiteId)
                        ->limit(1);
            })
            ->where('nombre_paso', $nombrePaso)
            ->first();

        if ($catalogoPaso) {
            $this->catalogo_paso_id = $catalogoPaso->id;

            // Buscar la validación de este paso
            $this->validacionPaso = ValidacionPasoTramite::where('tramite_id', $tramiteId)
                ->where('catalogo_paso_id', $catalogoPaso->id)
                ->first();
        } else {
            $this->catalogo_paso_id = null;
            $this->validacionPaso = null;
        }
    }



    public function render()
    {

        $vista = 'livewire.pasosUsoSuelo.' . $this->pasos_puntero;
        // if (!view()->exists($vista)) {
        //     $vista = 'livewire.pasosUsoSuelo.datos_personales_solicitante';
        // }

        return view($vista);
    }
}
