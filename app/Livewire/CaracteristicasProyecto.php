<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CatalogoImpacto;
use App\Models\CatalogoConstruccion;
use App\Models\CatalogoInfraestructura;


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

    public $tramiteId;
    protected $listeners = ['guardarDatos'];


    public function guardarDatos() {}


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
