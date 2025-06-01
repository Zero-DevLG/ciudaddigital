<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Tramite;

class TramitesDisponibles extends Component
{

    public $tramites = [];

    public  function mount()
    {
        $this->tramites = Tramite::all();

    }



    public function render()
    {
        return view('livewire.tramites-disponibles');
    }
}
