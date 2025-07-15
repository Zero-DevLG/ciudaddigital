<?php

namespace App\Livewire\Usosuelo;

use App\Models\Persona;
use App\Models\TramitePersona;
use Livewire\Component;

class DatosSolicitante extends Component
{

    public $nombre;
    public $apellido_paterno;
    public $apellido_materno;
    public $rfc;
    public $curp;
    public $tramite_id;
    public $telefono;
    public $correo_electronico;
    public $persona_id = null;
    public $listeners = ['guardarDatos'];
    public $persona;
    public $tramite_estatus;
    public bool $modo_edicion;


    public function mount($tramiteId, $tramiteEstatus)
    {
        $this->tramite_id = $tramiteId;

        $this->tramite_estatus = $tramiteEstatus;

         $this->modo_edicion = in_array((int)$this->tramite_estatus, [1, 5]);




        // Cargar datos de la persona si ya existe
        $this->persona = TramitePersona::where('tramite_id', $this->tramite_id)->first();



        if ($this->persona) {
            $this->nombre = $this->persona->persona->nombre;
            $this->apellido_paterno = $this->persona->persona->apellido_paterno;
            $this->apellido_materno = $this->persona->persona->apellido_materno;
            $this->rfc = $this->persona->persona->rfc;
            $this->curp = $this->persona->persona->curp;
            $this->telefono = $this->persona->telefono;
            $this->correo_electronico = $this->persona->correo_electronico;

            $this->persona_id = $this->persona->persona_id; // Guardar el ID de la persona para futuras actualizaciones

        }
    }



    public function guardarDatos()
    {


        $this->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'rfc' => 'required|string|size:13',
            'curp' => 'required|string|size:18',
            'telefono' => 'nullable|string|max:15',
            'correo_electronico' => 'nullable|email|max:255',
        ]);

        // 1. Guardar persona en la base de datos


        if ($this->persona) {


            // Actualizar persona existente
            $persona = Persona::find($this->persona_id);
            if ($persona) {
                $persona->update([
                    'nombre' => $this->nombre,
                    'apellido_paterno' => $this->apellido_paterno,
                    'apellido_materno' => $this->apellido_materno,
                    'rfc' => strtoupper($this->rfc),
                    'curp' => strtoupper($this->curp),
                    'telefono' => $this->telefono,
                    'correo_electronico' => $this->correo_electronico,
                ]);
            }
        } else {
            // Crear persona nueva
            $persona = Persona::create([
                'nombre' => $this->nombre,
                'apellido_paterno' => $this->apellido_paterno,
                'apellido_materno' => $this->apellido_materno,
                'rfc' => strtoupper($this->rfc),
                'curp' => strtoupper($this->curp),
                'telefono' => $this->telefono,
                'correo_electronico' => $this->correo_electronico,
            ]);
            $this->persona_id = $persona->id; // guardar el nuevo id para futuros updates
        }

        TramitePersona::updateOrCreate(
            [
                'tramite_id' =>  $this->tramite_id,
                'persona_id' => $persona->id,
            ]
        );

        $this->dispatch('siguientePaso'); // Emitir evento para pasar al siguiente paso del trámite
    }




    public function render()
    {
        return view('livewire.usosuelo.datos-solicitante');
    }
}
