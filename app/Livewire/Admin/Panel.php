<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Panel extends Component
{
    public string $vistaActiva = 'configuracion';


    public function changeView($vista)
    {
        if ($this->vistaActiva === $vista) {
            dd($vista);
            $this->vistaActiva = '';
            $this->dispatch('vista-reseteada');
        }

        $this->vistaActiva = $vista;
    }


    public function render()
    {
        return view('livewire.admin.panel');
    }
}
