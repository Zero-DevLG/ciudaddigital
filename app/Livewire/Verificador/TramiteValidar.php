<?php

namespace App\Livewire\Verificador;

use Livewire\Component;

use App\Models\TramiteC;
use App\Models\TipoTramite;
use App\Models\CatalogoPasosTramite;

class TramiteValidar extends Component
{


    public $tramite_id;
    public $pasos_puntero;
    public $tramite;
    public $tipo_tramite;

    public function mount($tramiteId){

        $this->tramite_id = $tramiteId;

        $this->tramite =  $tramite = TramiteC::findOrFail($tramiteId);

       $this->tipo_tramite =  $tramite_tipo = TipoTramite::findOrFail($tramite->tipo_tramite_id);
        $this->pasos_puntero = CatalogoPasosTramite::where('tipo_tramite_id', $tramite_tipo->id)
            ->orderBy('n_paso')
            ->get();

    }


    public function render()
    {
        return view('livewire.verificador.tramite-validar');
    }
}
