<?php

namespace App\Livewire\Usosuelo;

use Livewire\Component;

class DatosSolicitante extends Component
{

    public $nombre;
    public $apellido_paterno;
    public $apellido_materno;
    public $rfc;
    public $curp;

    public function render()
    {
        return view('livewire.usosuelo.datos-solicitante');
    }
}
