<?php

namespace App\Livewire;

use App\Models\CatalogoPasosTramite;
use Livewire\Component;

class FlujoPasosTramite extends Component
{

    public $tipoTramiteId;
    public $pasos = [];
    public $pasoActual = null;


    public function mount($tipoTramiteId)
    {

        $this->tipoTramiteId = $tipoTramiteId;

        $this->pasos = CatalogoPasosTramite::where('tipo_tramite_id', $this->tipoTramiteId)
            ->orderBy('n_paso')
            ->get();

        // dd($this->pasos); // Para depurar y ver los pasos cargados

    }



    public function render()
    {
        return view('livewire.flujo-pasos-tramite');
    }
}
