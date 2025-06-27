<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CatalogoImpacto;
use App\Models\CatalogoConstruccion;
use App\Models\CatalogoInfraestructura;
use App\Services\DocumentoService;
use App\Models\TramiteProyecto;

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


    public function guardarDatos(DocumentoService $documentoService) {

         $this->validate([
        'descripcion_general'      => 'required|string',
        'impacto_estimado_id'      => 'required|exists:catalogo_impactos,id',
        'tipo_construccion_id'     => 'required|exists:catalogo_construccions,id',
        'niveles'                  => 'required|integer|min:1',
        'infraestructura_seleccionada' => 'nullable|array',
        'plano'                    => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        'estudio_impacto'          => 'nullable|file|mimes:pdf',
    ]);

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

         $tramite_proyecto = TramiteProyecto::updateOrCreate([
            'tramite_id' => $this->tramiteId,
            'descripcion_general'         => $this->descripcion_general,
            'impacto_estimado_id'         => $this->impacto_estimado_id,
            'tipo_construccion_id'        => $this->tipo_construccion_id,
            'niveles'                     => $this->niveles,
            'infraestructura_seleccionada'=> $this->infraestructura_seleccionada,
            'plano_documento_id'          => $planoDocumento?->id,
            'estudio_impacto_documento_id'=> $estudioImpactoDocumento?->id,
         ]);


         $this->dispatch('siguientePaso');



    }


    public function formularioToogle($valor)
    {
        $this->showForm = $valor;
    }


    public function mount($tramiteId)
    {

        $this->tramiteId = $tramiteId;

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
