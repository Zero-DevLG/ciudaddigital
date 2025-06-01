<?php

namespace App\Livewire;


use Livewire\Component;

use Livewire\WithFileUploads;
use App\Models\Tramite;
use App\Models\PasosTramite;
use App\Models\CampoPaso;
use App\Models\TramiteFormato;
use App\Models\InstanciaTramite;
use App\Models\RespuestaFormulario;
use Illuminate\Support\Facades\Auth;


class TramiteWizard extends Component
{
     use WithFileUploads;

    public $tramite;
    public $formato;
    public $pasos;
    public int $pasoActual = 0;
    public $data = [];
    public $instancia;

    public function mount(Tramite $tramite)
    {

        $this->tramite = $tramite;


        // Obtener el formato publicado

        $this->formato = TramiteFormato::where('tramite_id', $tramite->id)
                                         ->where('publicado',1)
                                         ->firstOrFail();

        //Obtener o crear la instancia para este usuario
        $this->instancia = InstanciaTramite::firstOrCreate([
            'tramite_id'            =>  $this->tramite->id,
            'tramite_formato_id'    =>  $this->formato->id,
            'user_id'               =>  Auth::id()
        ]);

        // Obtener pasos con sus campos
        //$this->pasos = $this->formato->pasos()->with('campos')->get();

        $this->pasos = PasosTramite::with('campos')->where('tramite_formato_id', $this->formato->id) ->get();

        // Cargar respuestas ya guardadas
        foreach($this->instancia->respuestas as $respuesta){
            $this->data[$respuesta->campo_paso_id] = $respuesta->valor;
        }




    }


    private function esFechaValida($fecha)
    {
        return $fecha && \DateTime::createFromFormat('Y-m-d', $fecha) !== false;
    }

    public function guardarPasoActual()
{
    $paso = $this->pasos[$this->pasoActual];
    $campos = CampoPaso::where('pasos_tramite_id', $paso->id)->get();

    foreach ($campos as $campo) {
        $valor = $this->data[$campo->id] ?? null;

        $atributos = [
            'instancia_tramite_id' => $this->instancia->id,
            'campo_pasos_id' => $campo->id,
        ];

        // Inicializa todos los campos a null para limpiar valores anteriores
        $valores = [
            'valor_texto' => null,
            'valor_opcion' => null,
            'valor_entero' => null,
            'valor_decimal' => null,
            'valor_booleano' => null,
            'valor_fecha' => null,
            'archivo_ruta' => null,
        ];

        switch ($campo->tipo) {
            case 'text':
                $valores['valor_texto'] = is_string($valor) ? $valor : null;
                break;
            case 'option':
                $valores['valor_opcion'] = is_string($valor) ? $valor : null;
                break;
            case 'integer':
                $valores['valor_entero'] = is_numeric($valor) ? (int) $valor : null;
                break;
            case 'decimal':
                $valores['valor_decimal'] = is_numeric($valor) ? (float) $valor : null;
                break;
            case 'boolean':
                $valores['valor_booleano'] = filter_var($valor, FILTER_VALIDATE_BOOLEAN);
                break;
            case 'date':
                $valores['valor_fecha'] = $this->esFechaValida($valor) ? $valor : null;
                break;
            case 'file':
                // Manejo especial para archivos si es necesario
               if ($valor) {
                    $ruta = $valor->store('archivos', 'public'); // o la ruta que uses
                    $valores['archivo_ruta'] = $ruta;
                }
                break;
        }

        RespuestaFormulario::updateOrCreate($atributos, $valores);
    }
}




    public function siguientePaso()
    {

        $this->guardarPasoActual();

        if ($this->pasoActual < count($this->pasos) - 1) {
            $this->pasoActual++;
        }
    }

    public function pasoAnterior()
    {

        $this->guardarPasoActual();

        if ($this->pasoActual > 0) {
            $this->pasoActual--;
        }
    }

    public function render()
    {
        $paso = $this->pasos[$this->pasoActual] ?? null;

    // Cargamos campos si no están cargados aún (opcional si ya usaste with)
    if ($paso && !$paso->relationLoaded('campos')) {
        $paso->load('campos');
    }

    return view('livewire.tramite-wizard', compact('paso'));
    }
}
