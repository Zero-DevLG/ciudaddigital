<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Tramite;
use App\Models\TramiteFormato;
use App\Models\PasosTramite;
use App\Models\CampoPaso;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


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




    // PASOS



    public $showModalContenidoPasos = false;
    public $pasoActualId;



    // Propiedades para el formulario "Agregar Nuevo Campo"
    public $nombreCampo; // Etiqueta visible
    public $nombreTecnicoCampo; // Nombre técnico/key
    public $tipoCampo = 'text'; // Tipo de campo (default 'text')
    public $opcionesCampo; // Opciones para select, radio, checkbox (string comma-separated)
    public $infoAdicionalCampo; // Texto de ayuda/información adicional
    public $valorPredeterminadoCampo; // Valor inicial por defecto
    public $requeridoCampo = false; // Si el campo es obligatorio

    // Array para almacenar los campos en la "vista previa" antes de guardar
    public $camposPreview = [];


    public $currentPasoId;

    // --- Ciclo de Vida / Listeners ---

    // Listener para abrir el modal desde otro componente (si es necesario)
    // Por ejemplo, si llamas `Livewire.dispatch('openContenidoModal', { pasoId: paso.id })`
    protected $listeners = ['openContenidoModal' => 'abrirModalContenidoPasos', 'cerrarModalContenidoPasos'];




    public function abrirModalContenidoPasos($pasoId)
    {
        $this->currentPasoId = $pasoId;
        $this->showModalContenidoPasos = true;
    }

    public function cerrarModalContenidoPasos()
    {
        $this->showModalContenidoPasos = false;
    }


    protected function rules()
    {
        // Reglas de validación dinámicas
        $rules = [
            'nombreCampo' => 'required|string|max:255',
            'nombreTecnicoCampo' => 'nullable|string|max:255|regex:/^[a-z0-9_]+$/', // Letras minúsculas, números y guion bajo
            'tipoCampo' => 'required|in:text,textarea,email,number,date,file,select,radio,checkbox',
            'opcionesCampo' => '', // Validación condicional abajo
            'infoAdicionalCampo' => 'nullable|string|max:500',
            'valorPredeterminadoCampo' => 'nullable|string|max:500',
            'requeridoCampo' => 'boolean',
        ];

        // Validar opciones solo si el tipo lo requiere
        if (in_array($this->tipoCampo, ['select', 'radio', 'checkbox'])) {
            $rules['opcionesCampo'] = 'required|string|min:1'; // Requiere opciones si es uno de estos tipos
        } else {
            $rules['opcionesCampo'] = 'nullable'; // Opciones no son necesarias para otros tipos
        }


        return $rules;
    }

    // Mensajes de validación personalizados
    protected $messages = [
        'nombreCampo.required' => 'La etiqueta del campo es obligatoria.',
        'nombreCampo.max' => 'La etiqueta del campo no debe superar :max caracteres.',
        'nombreTecnicoCampo.regex' => 'El nombre técnico solo puede contener letras minúsculas, números y guiones bajos.',
        'tipoCampo.required' => 'Debe seleccionar un tipo de campo.',
        'tipoCampo.in' => 'El tipo de campo seleccionado no es válido.',
        'opcionesCampo.required' => 'Debe especificar las opciones separadas por comas para este tipo de campo.',
        'infoAdicionalCampo.max' => 'La información adicional no debe superar :max caracteres.',
        'valorPredeterminadoCampo.max' => 'El valor predeterminado no debe superar :max caracteres.',
    ];



    // Método para agregar un campo a la lista de vista previa
    public function agregarCampoPreview()
    {
        $this->validate(); // Ejecuta las reglas de validación

        // Generar nombre técnico si no se proporcionó
        $nombreTecnico = $this->nombreTecnicoCampo ?: Str::slug($this->nombreCampo, '_');

        // Asegurarse de que el nombre técnico generado no empiece con número si slugify lo crea así
        if (preg_match('/^\d/', $nombreTecnico)) {
            $nombreTecnico = '_' . $nombreTecnico;
        }

        // Validar que el nombre técnico generado o proporcionado no sea un duplicado en el preview
        if (collect($this->camposPreview)->pluck('nombre_tecnico')->contains($nombreTecnico)) {
            $this->addError('nombreTecnicoCampo', 'El nombre técnico "' . $nombreTecnico . '" ya existe en la lista de campos.');
            return;
        }


        // Procesar opciones si aplican
        $opciones = null;
        if (in_array($this->tipoCampo, ['select', 'radio', 'checkbox'])) {
            // Separar por comas y limpiar espacios
            $opciones = array_map('trim', explode(',', $this->opcionesCampo));
            // Opcional: remover opciones vacías resultantes de múltiples comas o espacios
            $opciones = array_filter($opciones, fn($value) => !is_null($value) && $value !== '');
        }

        // Crear la estructura del nuevo campo
        $nuevoCampo = [
            // Usar un UUID asegura que el ID sea único y estable para wire:key
            'id' => (string) Str::uuid(), // Genera un UUID único
            'nombre' => $this->nombreCampo,
            'nombre_tecnico' => $nombreTecnico,
            'tipo' => $this->tipoCampo,
            'opciones' => $opciones,
            'info_adicional' => $this->infoAdicionalCampo,
            'valorPredeterminadoCampo' => $this->valorPredeterminadoCampo, // ¡Ojo! Aquí debería ser 'valor_predeterminado' según tu Blade
            'requerido' => (bool) $this->requeridoCampo,
        ];


        // Añadir el nuevo campo al array de vista previa
        $this->camposPreview[] = $nuevoCampo;

        // Emitir un mensaje de éxito
        session()->flash('message_campos', 'Campo agregado a la lista.');

        // Limpiar el formulario después de agregar
        // $this->resetForm();
    }


    // Método para mover un campo hacia arriba en la lista de vista previa
    public function moveCampoUp($index)
    {
        if ($index > 0) {
            // Intercambiar el elemento actual con el anterior
            $temp = $this->camposPreview[$index];
            $this->camposPreview[$index] = $this->camposPreview[$index - 1];
            $this->camposPreview[$index - 1] = $temp;

            // Asegurarse de que wire:key se actualice si el ID no es estable
            // Si usas un ID estable (como UUID generado al añadir/cargar), esto no es tan crítico
            // Si el ID es index-based, podrías necesitar re-indexar:
            $this->camposPreview = array_values($this->camposPreview);
        }
    }

    // Método para mover un campo hacia abajo en la lista de vista previa
    public function moveCampoDown($index)
    {
        if ($index < count($this->camposPreview) - 1) {
            // Intercambiar el elemento actual con el siguiente
            $temp = $this->camposPreview[$index];
            $this->camposPreview[$index] = $this->camposPreview[$index + 1];
            $this->camposPreview[$index + 1] = $temp;

            // Re-indexar si es necesario (ver comentario en moveCampoUp)
            $this->camposPreview = array_values($this->camposPreview);
        }
    }

    // Método para eliminar un campo de la lista de vista previa
    public function eliminarCampoPreview($index)
    {
        if (isset($this->camposPreview[$index])) {
            unset($this->camposPreview[$index]); // Eliminar el elemento
            $this->camposPreview = array_values($this->camposPreview); // Re-indexar el array para evitar huecos en las claves
            session()->flash('message_campos', 'Campo eliminado de la lista.');
        }
    }


    // public function eliminarCampoPreview($index)
    // {
    //     unset($this->camposPreview[$index]);
    //     // Reindexar el array para evitar problemas con las claves después de eliminar un elemento.
    //     $this->camposPreview = array_values($this->camposPreview);
    // }

    // public function moveCampoUp($index)
    // {
    //     if ($index > 0) {
    //         $temp = $this->camposPreview[$index - 1];
    //         $this->camposPreview[$index - 1] = $this->camposPreview[$index];
    //         $this->camposPreview[$index] = $temp;
    //     }
    // }

    // public function moveCampoDown($index)
    // {
    //     if ($index < count($this->camposPreview) - 1) {
    //         $temp = $this->camposPreview[$index + 1];
    //         $this->camposPreview[$index + 1] = $this->camposPreview[$index];
    //         $this->camposPreview[$index] = $temp;
    //     }
    // }


    public function guardarCamposDelPaso()
    {
        if ($this->currentPasoId) {
            // Puedes añadir una validación final aquí si es necesario

            DB::transaction(function () {
                // 1. Eliminar todos los campos existentes para este paso
                CampoPaso::where('pasos_tramite_id', $this->currentPasoId)->delete();

                // 2. Crear nuevos registros en la tabla 'campo_pasos' para cada campo en la vista previa
                foreach ($this->camposPreview as $index => $campo) {
                    CampoPaso::create([
                        'pasos_tramite_id' => $this->currentPasoId,
                        'nombre_campo' => $campo['nombre'], // Mapear de preview a DB
                        'nombre_tecnico' => $campo['nombre_tecnico'], // Mapear
                        'tipo' => $campo['tipo'], // Mapear
                        'requerido' => $campo['requerido'], // Mapear
                        'opciones' => $campo['opciones'], // Mapear (Eloquent cast JSON)
                        'info_adicional' => $campo['info_adicional'] ?? null, // Mapear (puede ser null)
                        'valor_predeterminado' => $campo['valor_predeterminado'] ?? null, // Mapear (puede ser null)
                        // 'orden' => $index, // Opcional: Si añades una columna de orden
                    ]);
                }
            });


            session()->flash('message_campos', 'Campos guardados correctamente.');
            // Cerrar el modal después de guardar
            $this->cerrarModalContenidoPasos();

            // Opcional: Emitir un evento para notificar a otros componentes
            // $this->dispatch('camposDelPasoGuardados', ['pasoId' => $this->currentPasoId]);

        } else {
            session()->flash('message_campos', 'Error: ID del paso no definido al intentar guardar.');
        }
    }

    // Vista previa Pasos

    public $ModalVistaPaso = false;
    public $camposPasoSeleccionado = [];

    public function abrirModalVistaPaso($pasoId)
    {   
        $this->camposPasoSeleccionado = CampoPaso::where('pasos_tramite_id', $pasoId)->get();
        $this->ModalVistaPaso = true;
    }



    // END PASOS

    

    public function updatedTipoCampo($value)
    {
        // Cuando el valor de tipoCampo cambie, forzar la recarga (re-render) del componente
        $this->dispatch('render');
    }



    public function mount()
    {
        $this->cargarTramites();

        $this->tipoCampo = 'text';
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
