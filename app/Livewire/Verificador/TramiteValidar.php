<?php

namespace App\Livewire\Verificador;

use Livewire\Component;

use App\Models\TramiteC;
use App\Models\TipoTramite;
use App\Models\CatalogoPasosTramite;
use App\Models\Tramite;
use App\Models\TramiteResoluciones;

class TramiteValidar extends Component
{


    public $tramite_id;
    public $pasos_puntero;
    public $tramite;
    public $tipo_tramite;
    public $resolucion_prevencion;


    public function mount($tramiteId){

        $this->tramite_id = $tramiteId;

        $this->tramite =  $tramite = TramiteC::findOrFail($tramiteId);

       $this->tipo_tramite =  $tramite_tipo = TipoTramite::findOrFail($tramite->tipo_tramite_id);
        $this->pasos_puntero = CatalogoPasosTramite::where('tipo_tramite_id', $tramite_tipo->id)
            ->orderBy('n_paso')
            ->get();

        //Verificar si el tramite cuenta con una resolucion de prevencion
       $resolucion_prevencion = TramiteResoluciones::withTrashed()
            ->with([
                'tipoResolucion',
                'documento'
            ])
            ->where('tramite_id', $this->tramite_id)
            ->where('tipo_resolucion_id', 4)
            ->first();



        $this->resolucion_prevencion = $resolucion_prevencion;

    }


    public function test(){
        dd('Test method called');
    }


    public function render()
    {
        return view('livewire.verificador.tramite-validar');
    }
}
