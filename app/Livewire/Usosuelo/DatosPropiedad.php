<?php

namespace App\Livewire\Usosuelo;

use App\Models\CatalogoPropiedad;
use App\Models\CatalogoUsoSuelo;
use App\Models\Domicilios;
use App\Models\Predio;
use App\Models\PropiedadTramite;
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
    public $tramiteId;
    public $predio;
    public $predioTramite;


    //direccion
    public $domicilio;
    public $estado;
    public $delegacion_municipio;
    public $calle;
    public $n_exterior;
    public $n_interior;
    public $cp;

    protected $listeners = ['setCoordinates', 'guardarDatos'];




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



    public function mount($tramiteId)
    {


        $this->tramiteId = $tramiteId;
        $this->catalogoUsos = CatalogoUsoSuelo::all();
        $this->catalogoPropuestos = $this->catalogoUsos;
        $this->catalogoTipos = CatalogoPropiedad::all();


        // Si ya existe un predio cargado, cargar sus datos
        $this->predioTramite = PropiedadTramite::where('tramite_id', $this->tramiteId)->first();

        if ($this->predioTramite) {
            $this->predio = Predio::find($this->predioTramite->propiedad_id);
        }

        if ($this->predioTramite) {

            $this->domicilio = Domicilios::find($this->predio->domicilio_id);

            if ($this->domicilio) {
                $this->estado = $this->domicilio->estado;
                $this->delegacion_municipio = $this->domicilio->delegacion_municipio;
                $this->calle = $this->domicilio->calle;
                $this->n_exterior = $this->domicilio->n_exterior;
                $this->n_interior = $this->domicilio->n_interior;
                $this->cp = $this->domicilio->cp;
            }
        }



        if ($this->predio) {
            $this->clave_catastral = $this->predio->clave_catastral;
            $this->superficie_terreno = $this->predio->superficie_total;
            $this->uso_actual = $this->predio->uso_actual_suelo_id;
            $this->tipo_propiedad = $this->predio->tipo_propiedad_id;
            $this->uso_propuesto = $this->predio->uso_solicitado_id;
            $this->latitud = $this->predio->lat;
            $this->longitud = $this->predio->long;
        }
    }


    public function guardarDatos()
    {

        $this->validate([
            'clave_catastral' => 'required|string|max:255',
            'superficie_terreno' => 'required|numeric|min:0',
            'uso_actual' => 'required|exists:catalogo_uso_suelo,id',
            'tipo_propiedad' => 'required|exists:catalogo_tipo_propiedad,id',
            'uso_propuesto' => 'required|exists:catalogo_uso_suelo,id',

            'estado' => 'required|string|max:255',
            'delegacion_municipio' => 'required|string|max:255',
            'calle' => 'required|string|max:255',
            'n_exterior' => 'required|string|max:50',
            'n_interior' => 'nullable|string|max:50',
            'cp' => 'required|string|max:10',

        ]);

        if ($this->predio) {
            //Actualizar domicilio si es necesario
            $this->domicilio->update([
                'estado' => $this->estado,
                'delegacion_municipio' => $this->delegacion_municipio,
                'calle' => $this->calle,
                'n_exterior' => $this->n_exterior,
                'n_interior' => $this->n_interior,
                'cp' => $this->cp,
            ]);




            // Actualizar predio existente
            $this->predio->update([
                'clave_catastral' => $this->clave_catastral,
                'superficie_total' => $this->superficie_terreno,
                'uso_actual_suelo_id' => $this->uso_actual,
                'tipo_propiedad_id' => $this->tipo_propiedad,
                'uso_solicitado_id' => $this->uso_propuesto,
                'lat' => $this->latitud,
                'long' => $this->longitud,
                'acceso_vialidades' => $this->acceso_vialidad,
                'zona_urbana' => $this->zona_urbana,
            ]);
        } else {

            //Crear nuevo domicilio
            $domicilio = Domicilios::create([
                'estado' => $this->estado,
                'delegacion_municipio' => $this->delegacion_municipio,
                'calle' => $this->calle,
                'n_exterior' => $this->n_exterior,
                'n_interior' => $this->n_interior,
                'cp' => $this->cp,
            ]);

            // Crear nuevo predio
            $predioC = Predio::create([
                'domicilio_id' => $domicilio->id,
                'clave_catastral' => $this->clave_catastral,
                'lat' => $this->latitud,
                'long' => $this->longitud,
                'superficie_total' => $this->superficie_terreno,
                'uso_actual_suelo_id' => $this->uso_actual,
                'tipo_propiedad_id' => $this->tipo_propiedad,
                'uso_solicitado_id' => $this->uso_propuesto,

                'acceso_vialidades' => $this->acceso_vialidad,
                'zona_urbana' => $this->zona_urbana,
            ]);
        }

        #Crear la relacion predio tramite
        if (!$this->predioTramite) {
            PropiedadTramite::create([
                'propiedad_id' => $predioC->id,
                'tramite_id' => $this->tramiteId,
            ]);
        }


        $this->dispatch('siguientePaso');
    }



    public function render()
    {
        $this->dispatch('initMapaLeaflet');
        return view('livewire.usosuelo.datos-propiedad');
    }
}
