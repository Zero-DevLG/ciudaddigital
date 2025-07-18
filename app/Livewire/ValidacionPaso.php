<?php

namespace App\Livewire;

use App\Models\PrevencionesTramite;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;


class ValidacionPaso extends Component
{
    public $es_valido = 0;
    public $observaciones = '';
    public $mensajeExito = '';
    public $tramiteId;
    public $pasoId;

    protected $listeners = ['updateRadio'];

    public function mount($tramiteId, $pasoId)
    {
        $this->tramiteId = $tramiteId;
        $this->pasoId = $pasoId;

        // Cargar la prevención existente si existe
        $prevencion = PrevencionesTramite::where('tramite_id', $this->tramiteId)
            ->where('catalogo_paso_id', $this->pasoId)
            ->first();



        if($prevencion) {
            $this->es_valido = 1;
        } else {
            $this->es_valido = 0; // Valor por defecto si no existe
        }
        $this->observaciones = $prevencion ? $prevencion->observaciones : '';




    }



    public function guardarPrevencion()
    {

        dd('Guardando prevencion...');
        // Guardar prevencion
        $prevencionPaso = PrevencionesTramite::updateOrCreate(
            [
                'tramite_id' => $this->tramiteId,
                'catalogo_paso_id' => $this->pasoId,
            ],
            [
                'es_valido' => $this->es_valido,
                'observaciones' => $this->observaciones,
                'verificador_id' => Auth::id(),
            ]
        );




    }


    #[On('post-created')]
public function handleNewPost($refreshPosts = false)
{
    //
}

    public function render()
    {
        return view('livewire.validacion-paso');
    }
}
