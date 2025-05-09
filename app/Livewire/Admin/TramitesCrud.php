<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Tramite;
use App\Models\TramiteFormato;
use App\Models\PasosTramite;


class TramitesCrud extends Component
{

    public $tramites;
    public $id, $nombre, $code, $active = true;
    public $modoEditar = false;
    public $tramiteEditando;
    public $tramiteResumen;
    public $tramiteFormato;

    public $id_tramite;



    public $showModal = false;

    public $showModalResumen = false;

    public $showModalFormato = false;

    public $vistaActual = 'index';
    public $formatoSeleccionadoId;





    // Secciones

    public function crearSecciones($formatoSId)
    {

        $this->formatoSeleccionadoId = $formatoSId;

        $this->cargarPasos();

        $this->vistaActual = 'crear-contenido';
    }



    // END Secciones



    // FORMATOS

    public $formatos = [];
    public $formatoNombre, $formatoDescripcion;
    public $modoEditarFormato = false;
    public $formatoEditando = null;


    public function abrirModalFormato($tramiteFormato)
    {
        $this->id_tramite = $tramiteFormato->id;

        $this->showModalFormato = true;
    }

    public function cerrarModalFormato()
    {
        $this->showModalFormato = false;
    }

    public function verFormatoTramite($id)
    {
        $this->tramiteFormato = Tramite::findOrFail($id);

        $this->abrirModalFormato($this->tramiteFormato);
    }



    public function cargarFormatos($id)
    {

        $this->formatos = TramiteFormato::where('tramite_id', $this->id)->get();
        if ($this->tramiteEditando) {
            $this->formatos = $this->tramiteEditando->formatos()->orderBy('created_at', 'desc')->get();
        } else {
        }
    }

    public function guardarFormato()
    {
        $this->validate([
            'formatoNombre' => 'required|string|max:255',
            'formatoDescripcion' => 'nullable|string',
        ]);

        if ($this->modoEditarFormato && $this->formatoEditando) {
            $this->formatoEditando->update([
                'nombre_formato' => $this->formatoNombre,
                'descripcion' => $this->formatoDescripcion,
            ]);
        } else {
            TramiteFormato::create([
                'tramite_id' => $this->id,
                'nombre_formato' => $this->formatoNombre,
                'descripcion' => $this->formatoDescripcion,
            ]);
        }

        $this->resetFormato();
        $this->cargarFormatos($this->id);
        $this->showModalFormato = false;
    }

    // Editar
    public function editarFormato($id)
    {
        $this->modoEditarFormato = true;
        $this->formatoEditando = \App\Models\TramiteFormato::findOrFail($id);
        $this->formatoNombre = $this->formatoEditando->nombre_formato;
        $this->formatoDescripcion = $this->formatoEditando->descripcion;
    }

    // Eliminar
    public function eliminarFormato($id)
    {
        \App\Models\TramiteFormato::findOrFail($id)->delete();
        $this->cargarFormatos($this->id);
    }



    // Reset
    public function resetFormato()
    {
        $this->formatoNombre = '';
        $this->formatoDescripcion = '';
        $this->modoEditarFormato = false;
        $this->formatoEditando = null;
    }






    public function mount()
    {
        $this->cargarTramites();
    }

    public function cargarTramites()
    {
        $this->tramites = Tramite::orderBy('created_at', 'desc')->get();
    }

    public function abrirModal2()
    {
        $this->resetForm();
        $this->showModal = true;
    }


    public function abrirModalResumen()
    {

        $this->resetForm();
        $this->showModalResumen;
    }


    public function cerrarModal()
    {
        $this->showModal = false;
    }

    public function resetForm()
    {
        $this->nombre = '';
        $this->code = '';
        $this->active = true;
        $this->modoEditar = false;
        $this->tramiteEditando = null;
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:tramites,code,' . ($this->tramiteEditando->id ?? 'NULL'),
            'active' => 'boolean',
        ]);

        if ($this->modoEditar && $this->tramiteEditando) {
            $this->tramiteEditando->update([
                'nombre' => $this->nombre,
                'code' => $this->code,
                'active' => $this->active,
            ]);
        } else {

            Tramite::create([
                'nombre' => $this->nombre,
                'code' => $this->code,
                'active' => $this->active,
            ]);
        }

        $this->cerrarModal();
        $this->cargarTramites();
    }

    public function editar($id)
    {
        $this->modoEditar = true;
        $this->tramiteEditando = Tramite::findOrFail($id);
        $this->nombre = $this->tramiteEditando->nombre;
        $this->code = $this->tramiteEditando->code;
        $this->active = $this->tramiteEditando->active;
        $this->showModal = true;
    }

    public function verResumenTramite($id)
    {
        $this->tramiteResumen = Tramite::findOrFail($id);
        $this->id = $this->tramiteResumen->id;
        $this->nombre = $this->tramiteResumen->nombre;
        $this->code = $this->tramiteResumen->code;
        $this->active = $this->tramiteResumen->active;

        $this->formatos = TramiteFormato::where('tramite_id', $id)->get();

        $this->showModalResumen = true;
    }

    public function cerrarModalResumen()
    {
        $this->showModalResumen = false;
    }




    public function eliminar($id)
    {
        Tramite::findOrFail($id)->delete();
        $this->cargarTramites();
    }



    // Logica tramitesCrearContenido



  
    public $showModalpasos = false;
    public $pasos = [];
    public $titulo_paso, $descripcion, $orden, $estatus = true;
    public $pasoEditando = null;
    public $tramiteFormatoId;

    
    public function abrirModalContenido()
    {
        
        $this->resetFormpasos();
        $this->showModalpasos = true;
    }

    public function cerrarModalPasos()
    {
        $this->showModalpasos = false;
    }

    public function cargarPasos()
    {
        $this->pasos = PasosTramite::where('tramite_formato_id', $this->formatoSeleccionadoId)
            ->orderBy('orden')
            ->get();
    }

    public function resetFormpasos()
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
                'tramite_formato_id' =>  $this->formatoSeleccionadoId,
                'titulo_paso' => $this->titulo_paso,
                'descripcion' => $this->descripcion,
                'orden' => $this->orden,
                'estatus' => $this->estatus,
            ]);
        }

        $this->cargarPasos();

        $this->cerrarModalPasos();
    }



    // END






    public function render()
    {
        if ($this->vistaActual === 'crear-contenido') {
            return view('livewire.admin.tramites-crear-contenido', [
                'formato' => TramiteFormato::findOrFail($this->formatoSeleccionadoId)
            ]);
        }

        return view('livewire.admin.tramites-crud');
    }
}
