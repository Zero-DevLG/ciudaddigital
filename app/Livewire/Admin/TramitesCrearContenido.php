<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\TramiteFormato;
use App\Models\PasosTramite;

class TramitesCrearContenido extends Component
{

    public $formatoSeleccionadoId;

    public $formato;


    public $tramiteFormatoId;
    public $pasos = [];
    public $titulo_paso, $descripcion, $orden, $estatus = true;
    public $pasoEditando = null;
    public $modoEditar = false;
    public $showModalpasos = false;


    public function cargarPasos()
    {
        $this->pasos = PasosTramite::where('tramite_formato_id', $this->tramiteFormatoId)
            ->orderBy('orden')
            ->get();
    }

    public function abrirModalContenido()
    {
        $this->resetForm();
        $this->showModalpasos = true;
    }

    public function cerrarModal()
    {
        $this->showModalpasos = false;
    }

    public function resetForm()
    {
        $this->titulo_paso = '';
        $this->descripcion = '';
        $this->orden = '';
        $this->estatus = true;
        $this->pasoEditando = null;
        $this->modoEditar = false;
    }

    public function guardarPaso()
    {
        $this->validate([
            'titulo_paso' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'orden' => 'required|integer',
            'estatus' => 'boolean',
        ]);

        if ($this->modoEditar && $this->pasoEditando) {
            $this->pasoEditando->update([
                'titulo_paso' => $this->titulo_paso,
                'descripcion' => $this->descripcion,
                'orden' => $this->orden,
                'estatus' => $this->estatus,
            ]);
        } else {
            PasosTramite::create([
                'tramite_formato_id' => $this->tramiteFormatoId,
                'titulo_paso' => $this->titulo_paso,
                'descripcion' => $this->descripcion,
                'orden' => $this->orden,
                'estatus' => $this->estatus,
            ]);
        }

        $this->cerrarModal();
        $this->cargarPasos();
    }

    public function editarPaso($id)
    {
        $this->modoEditar = true;
        $this->pasoEditando = PasosTramite::findOrFail($id);
        $this->titulo_paso = $this->pasoEditando->titulo_paso;
        $this->descripcion = $this->pasoEditando->descripcion;
        $this->orden = $this->pasoEditando->orden;
        $this->estatus = $this->pasoEditando->estatus;
        $this->showModalpasos = true;
    }

    public function eliminarPaso($id)
    {
        PasosTramite::findOrFail($id)->delete();
        $this->cargarPasos();
    }



    public function mount($formatoSeleccionadoId)
    {
        $this->tramiteFormatoId = $formatoSeleccionadoId;

        $this->formatoSeleccionadoId = $formatoSeleccionadoId;

        $this->formato = TramiteFormato::findOrFail($formatoSeleccionadoId);

        $this->tramiteFormatoId = $formatoSeleccionadoId;

        $this->formatoSeleccionadoId = $formatoSeleccionadoId;
        $this->formato = TramiteFormato::findOrFail($formatoSeleccionadoId);

        $this->pasos = PasosTramite::where('tramite_formato_id', $formatoSeleccionadoId)
            ->orderBy('orden')
            ->get()
            ->toArray(); // ⚡️ importante: que sea array


    }


    public function render()
    {

        dd('TEST');
        return view(
            'livewire.admin.tramites-crear-contenido',
            [
                'formato'   =>  $this->formato,
                'pasos'     =>  $this->pasos,
            ]
        );
    }
}
