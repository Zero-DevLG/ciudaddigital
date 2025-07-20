<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CatalogoImpacto;
use App\Models\CatalogoConstruccion;
use App\Models\CatalogoInfraestructura;
use App\Services\DocumentoService;
use App\Models\TramiteProyecto;
use App\Models\TramiteC;
use App\Models\PrevencionesTramite;

class CaracteristicasProyecto extends Component
{

    use WithFileUploads;

    public $showForm = 'si';

    public $descripcion_general;
    public $impacto_estimado_id;
    public $plano;
    public $tipo_construccion_id;
    public $niveles;
    public $infraestructura_seleccionada = [];
    public $estudio_impacto;

    public $catalogoImpactos;
    public $catalogoConstrucciones;
    public $catalogoInfraestructura;

    public $planoExistente;
public $estudioImpactoExistente;

    public $tramiteId;
    protected $listeners = ['guardarDatos'];

     public $tramite_estatus;
    public $observaciones;
    public $prevencion_paso;
    public $modo_edicion;


    public function guardarDatos(DocumentoService $documentoService) {



         if ($this->plano) {
        $planoDocumento =$documentoService->storeDocumento(
            $this->plano,
            $this->tramiteId,
            6, // ID del documento "planos"
            'Plano o croquis del terreno'
        );
    }

    if ($this->estudio_impacto) {
       $estudioImpactoDocumento = $documentoService->storeDocumento(
            $this->estudio_impacto,
            $this->tramiteId,
            8, // ID del documento "estudio_impacto_ambiental"
            'Estudio de impacto ambiental'
        );
    }

    // dd($estudioImpactoDocumento);

    //Guardar datos

        $tramite_proyecto = TramiteProyecto::updateOrCreate(
            // Condiciones para buscar
            ['tramite_id' => $this->tramiteId],

            // Campos a actualizar o crear
            [
                'descripcion_general'          => $this->descripcion_general,
                'impacto_estimado_id'          => $this->impacto_estimado_id,
                'tipo_construccion_id'         => $this->tipo_construccion_id,
                'niveles'                      => $this->niveles,
                'infraestructura_seleccionada' => $this->infraestructura_seleccionada,
                'plano_documento_id'           => $planoDocumento->id ?? null,
                'estudio_impacto_documento_id' => $estudioImpactoDocumento->id ?? null,
            ]
        );


         $this->dispatch('siguientePaso');

    }


    public function formularioToogle($valor)
    {
        $this->showForm = $valor;
    }


    public function mount($tramiteId)
    {


        $this->tramiteId = $tramiteId;

          $tramite = TramiteC::find($this->tramiteId);

        $this->tramite_estatus = $tramite->cat_estatus_id;

        $prevencion_paso = PrevencionesTramite::where('tramite_id', $this->tramiteId)
            ->where('catalogo_paso_id', 3)
            ->first();


          $this->observaciones = $prevencion_paso->observaciones;


         $estatus_tramite_f = in_array((int)$this->tramite_estatus, [1, 5]);

           if ($estatus_tramite_f) {

             if ($prevencion_paso) {
                $this->prevencion_paso = $prevencion_paso->catalogo_paso_id;
                if($prevencion_paso->es_valido === 0){
                    $this->modo_edicion = true; // Permitir edición si hay una prevención válida
                } else {
                    $this->modo_edicion = false; // No permitir edición si no hay prevención válida
                }
            } else {
                $prevencion_paso = null;
            }
        } else {
            $this->modo_edicion = false; // No permitir edición en otros estatus
        }


        $this->catalogoImpactos = CatalogoImpacto::all();
        $this->catalogoConstrucciones = CatalogoConstruccion::all();
        $this->catalogoInfraestructura = CatalogoInfraestructura::all();


        // Cargar datos del trámite si existen
        $tramiteProyecto = TramiteProyecto::where('tramite_id', $this->tramiteId)->first();



        if ($tramiteProyecto) {
            $this->descripcion_general = $tramiteProyecto->descripcion_general;
            $this->impacto_estimado_id = $tramiteProyecto->impacto_estimado_id;
            $this->tipo_construccion_id = $tramiteProyecto->tipo_construccion_id;
            $this->niveles = $tramiteProyecto->niveles;
            $this->infraestructura_seleccionada = $tramiteProyecto->infraestructura_seleccionada;
            $this->planoExistente = $tramiteProyecto->planoDocumento?->url;
        $this->estudioImpactoExistente = $tramiteProyecto->estudioImpactoDocumento?->url;

            // dd($tramiteProyecto,$this->planoExistente, $this->estudioImpactoExistente);

        } else {
            $this->reset([
                'descripcion_general',
                'impacto_estimado_id',
                'plano',
                'tipo_construccion_id',
                'niveles',
                'infraestructura_seleccionada',
                'estudio_impacto'
            ]);

        }



    }

    public function updatedMostrarFormulario()
    {
        if ($this->mostrarFormulario === 'no') {
            $this->reset([
                'descripcion_general',
                'impacto_estimado_id',
                'plano',
                'tipo_construccion_id',
                'niveles',
                'infraestructura_seleccionada',
                'estudio_impacto'
            ]);
        }
    }


    public function render()
    {
        return view('livewire.caracteristicas-proyecto');
    }
}
