<?php

namespace App\Livewire;

use App\Models\TipoTramite;
use Livewire\Component;
use App\Models\TramiteC;

class TramitesDisponibles extends Component
{

    public $tramites = [];

    public  function mount()
    {
        $this->tramites = TipoTramite::all();
    }



    public function render()
    {
        return view('livewire.tramites-disponibles');
    }
}
