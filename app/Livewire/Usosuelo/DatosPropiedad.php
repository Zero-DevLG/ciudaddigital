<?php

namespace App\Livewire\Usosuelo;

use App\Models\CatalogoPropiedad;
use App\Models\CatalogoUsoSuelo;
use Database\Seeders\CatalogoTipoPropiedad;
use Livewire\Component;
use Livewire\Attributes\On;

class DatosPropiedad extends Component
{



    public $clave_catastral;
    public $superficie_terreno;
    public $uso_actual;
    public $tipo_propiedad;
    public $uso_propuesto;

    public $acceso_vialidad = false;
    public $zona_urbana = false;


    public $catalogoUsos = [];
    public $catalogoTipos = [];
    public $catalogoPropuestos = [];


    public $latitud;
    public $longitud;

    protected $listeners = ['setCoordinates'];




    public function setCoordinates($lat, $lng)
    {
        $this->latitud = $lat;
        $this->longitud = $lng;
        return $this->skipRender(); // <- esto evita que se re-renderice
    }


    #[On('tests')]
    public function test()
    {
        $this->dispatch('testEvent');
    }



    public function mount()
    {

        $this->catalogoUsos = CatalogoUsoSuelo::all();
        $this->catalogoPropuestos = $this->catalogoUsos;
        $this->catalogoTipos = CatalogoPropiedad::all();
    }


    public function render()
    {
        $this->dispatch('initMapaLeaflet');
        return view('livewire.usosuelo.datos-propiedad');
    }
}
