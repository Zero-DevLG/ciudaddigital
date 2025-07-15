<?php

namespace App\Livewire;

use App\Models\PropiedadTramite;
use App\Models\Tramite;
use Livewire\Component;
use App\Models\TramitePersona;
use App\Models\TramiteProyecto;
use App\Models\DocumentosTramite;

class ResumenTramite extends Component
{

    public $tramiteId;
    public $persona;
    public $predio;
    public $domicilio_predio;
    public $tipo_propiedad;
    public $uso_suelo_actual;
    public $uso_suelo_solicitado;
    public $tramite_proyecto;
    public $impacto_estimado;
    public $tipo_construccion;
    public $car_proyecto;
    public $plano_documento;
    public $estudio_impacto_documento;
    public $documentos_tramite;




    public function mount($tramiteId)
    {
        $this->tramiteId = $tramiteId;

        //Obtenemos solicitante
        $persona_tramite = TramitePersona::where('tramite_id', $this->tramiteId)
            ->first();

        if($persona_tramite) {
            $this->persona = $persona_tramite->persona; // Asignamos la persona asociada al tramite
        } else {
            $this->persona = null; // O maneja el caso donde no se encuentra la persona
        }

        //Obtener uinformacion predio
        $propiedad_tramite = PropiedadTramite::with('predio.domicilio', 'predio.tipoPropiedad', 'predio.usoActual', 'predio.usoSolicitado')->where('tramite_id', $this->tramiteId)
            ->first();



        if($propiedad_tramite) {
            $this->predio = $propiedad_tramite->predio; // Asignamos la propiedad asociada al tramite
            $this->domicilio_predio = $this->predio->domicilio;
            $this->tipo_propiedad = $this->predio->tipoPropiedad; // Asignamos el tipo de propiedad
            $this->uso_suelo_actual = $this->predio->usoActual; // Asignamos el uso actual del suelo
            $this->uso_suelo_solicitado = $this->predio->usoSolicitado; // Asignamos el uso solicitado del suelo




        } else {
            $this->predio = null; // O maneja el caso donde no se encuentra la propiedad
        }

        //Obtener características del proyecto
        $this->car_proyecto = TramiteProyecto::with('impactoEstimado', 'tipoConstruccion','planoDocumento','estudioImpactoDocumento')->where('tramite_id', $this->tramiteId)
            ->first();

        //dd($this->car_proyecto);


        if($this->car_proyecto) {
            $this->tramite_proyecto = $this->car_proyecto; // Asignamos las características del proyecto
            $this->impacto_estimado = $this->car_proyecto->impactoEstimado; // Asignamos el impacto estimado
            $this->tipo_construccion = $this->car_proyecto->tipoConstruccion; // Asignamos el tipo de construcción
            $this->plano_documento = $this->car_proyecto->planoDocumento; // Asignamos el documento del plano
            $this->estudio_impacto_documento = $this->car_proyecto->estudioImpactoDocumento; // Asignamos el documento del estudio de impacto

        } else {
            $this->tramite_proyecto = null; // O maneja el caso donde no se encuentra el proyecto
        }


        //obtener documentos tramite
        $this->documentos_tramite = DocumentosTramite::where('tramite_id', $this->tramiteId)
            ->get();


    }


    public function render()
    {
        return view('livewire.resumen-tramite');
    }
}
