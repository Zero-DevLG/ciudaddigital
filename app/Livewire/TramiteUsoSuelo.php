<?php

namespace App\Livewire;

use Livewire\Component;






class TramiteUsoSuelo extends Component
{



    public int $pasoActual = 0;

    // Ejemplo de pasos, puedes cargarlo dinámicamente si quieres
    public array $pasos = [
        ['titulo' => 'Datos del Solicitante', 'descripcion' => 'Introduce la información del solicitante.'],
        ['titulo' => 'Datos de la Propiedad', 'descripcion' => 'Proporciona los datos de la propiedad.'],
        ['titulo' => 'Confirmación', 'descripcion' => 'Revisa y confirma los datos.'],
    ];

    public function siguientePaso()
    {
        if ($this->pasoActual < count($this->pasos) - 1) {
            $this->pasoActual++;
            $this->dispatch('pasoCambiado', $this->pasoActual);
        }

        if ($this->pasoActual === 1) {
            $this->dispatch('tests');
        }
    }

    public function pasoAnterior()
    {
        if ($this->pasoActual > 0) {
            $this->pasoActual--;
            $this->dispatch('pasoCambiado', $this->pasoActual);
        }
    }

    public function mount()
    {
        // Emitimos el paso inicial para que el JS ejecute si es paso 1 al cargar
        $this->dispatch('pasoCambiado', $this->pasoActual);
    }


    public function render()
    {
        return view('livewire.tramite-uso-suelo');
    }
}
