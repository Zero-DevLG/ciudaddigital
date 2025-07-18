<?php

namespace App\Livewire;

use App\Models\CatalogoResolucion;
use App\Models\TramiteResoluciones;
use Livewire\Component;

class ResolucionTramite extends Component
{
    public $tramiteId;
    public $mostrarVistaPrevia = false;
    public $rutaPdf;
    public $resolucion_prevencion;
    public $catalogoResoluciones;

    public function mount($tramiteId)
    {
        $this->tramiteId = $tramiteId;

        $this->resolucion_prevencion = TramiteResoluciones::where('tramite_id', $this->tramiteId)
            ->first();

        $this->catalogoResoluciones = CatalogoResolucion::all();

        // Suponiendo que ya tienes la resolución generada y guardada:
        $this->rutaPdf = "/storage/resoluciones/resolucion_{$tramiteId}.pdf"; // ajusta según tu ruta real
    }

    public function toggleVistaPrevia()
    {
        $this->mostrarVistaPrevia = !$this->mostrarVistaPrevia;
    }

    public function render()
    {
        return view('livewire.resolucion-tramite');
    }
}
