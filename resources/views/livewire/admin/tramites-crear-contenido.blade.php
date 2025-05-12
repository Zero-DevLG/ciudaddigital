@php

    $config = app(App\Services\ConfigService::class);

    $config->clearCache();
@endphp



<div class="p-6 space-y-6">

    <!-- Botón para regresar -->
    <div>
        <button wire:click="$set('vistaActual', 'index')"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            ← Volver a Trámites
        </button>
    </div>

    <!-- Información del Formato -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-4">Crear contenido para: <span
                class="text-blue-600">{{ $formato->nombre_formato }}</span></h2>
        {{ $formato->id }}
        {{ $formatoSeleccionadoId }}
        <p class="text-gray-700 mb-2"><strong>Descripción:</strong> {{ $formato->descripcion }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">

        <h2 class="text-2xl font-bold mb-4">Pasos de formato: {{ $formato->nombre_formato }}</h2>

        <div class="flex justify-end mb-4">
            <button wire:click="abrirModalContenido" class="bg-green-600 text-white px-4 py-2 rounded">
                Nuevo Paso
            </button>
        </div>

        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Orden</th>
                    <th class="border p-2">Título</th>
                    <th class="border p-2">Descripción</th>
                    <th class="border p-2">Estatus</th>
                    <th class="border p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($pasos))
                    @foreach ($pasos as $paso)
                        <tr>
                            <td class="border p-2">{{ $paso->orden }}</td>
                            <td class="border p-2">{{ $paso->titulo_paso }}</td>
                            <td class="border p-2">{{ $paso->descripcion }}</td>
                            <td class="border p-2">{{ $paso->estatus ? 'Activo' : 'Inactivo' }}</td>
                            <td class="border p-2 flex gap-2">
                                <button wire:click="abrirModalContenidoPasos({{ $paso->id }})">Crear contenido del
                                    paso
                                </button>
                                <button wire:click="editarPaso({{ $paso->id }})"
                                    class="text-blue-600 hover:underline">Editar</button>
                                <button wire:click="eliminarPaso({{ $paso->id }})"
                                    class="text-red-600 hover:underline">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center p-4">No hay pasos registrados aún.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- Modal --}}
        @if ($showModalpasos)
            <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                    <h3 class="text-xl font-semibold mb-4">
                        {{ $modoEditar ? 'Editar Paso' : 'Crear Nuevo Paso' }}
                    </h3>


                    <form wire:submit.prevent="guardarPaso">
                        <div class="mb-4">
                            <label class="block font-medium">Título del paso</label>
                            <input type="text" wire:model.defer="titulo_paso" class="w-full border rounded p-2">
                            @error('titulo_paso')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium">Descripción</label>
                            <textarea wire:model.defer="descripcion" class="w-full border rounded p-2"></textarea>
                            @error('descripcion')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium">Orden</label>
                            <input type="number" wire:model.defer="orden" class="w-full border rounded p-2">
                            @error('orden')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" wire:model.defer="estatus">
                                <span>Activo</span>
                            </label>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" wire:click="cerrarModalPasos"
                                class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                                {{ $modoEditar ? 'Actualizar' : 'Guardar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif


        {{-- Modal contenido paso --}}
        {{-- Modal contenido paso (CAMPOS) --}}
        @if ($showModalContenidoPasos)
            <div class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-[100] overflow-y-auto p-4 transition-opacity duration-300 ease-out"
                x-data="{ showModal: @entangle('showModalContenidoPasos') }" x-show="showModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-3xl my-8 transform transition-all"
                    x-show="showModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    @click.away="showModal = false; Livewire.dispatch('cerrarModalContenidoPasos')"
                    {{-- Allow closing by clicking away --}}>
                    {{-- Cabecera del Modal --}}
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">

                        </h2>
                        <button wire:click="cerrarModalContenidoPasos" title="Cerrar modal"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-6">
                        @if (session()->has('message_campos'))
                            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                                class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded relative"
                                role="alert">
                                <span class="block sm:inline">{{ session('message_campos') }}</span>
                            </div>
                        @endif

                        {{-- Formulario para agregar un NUEVO campo a la VISTA PREVIA --}}
                        <div class="bg-slate-50 p-5 rounded-lg border border-slate-200 space-y-4">
                            <h3 class="text-md font-semibold text-gray-700 border-b pb-2 mb-3">Definir Nuevo Campo</h3>
                            {{-- Usamos wire:submit en el form y el botón type="submit" --}}
                            <form wire:submit.prevent="agregarCampoPreview" class="space-y-4">
                                {{-- Fila 1: Etiqueta y Nombre Técnico --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="nombreCampoModal"
                                            class="block text-sm font-medium text-gray-700 mb-1">Etiqueta (Visible)
                                            <span class="text-red-500">*</span></label>
                                        <input id="nombreCampoModal" wire:model.lazy="nombreCampo" type="text"
                                            class="form-input w-full" placeholder="Ej: Nombre completo" required>
                                        @error('nombreCampo')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="nombreTecnicoCampoModal"
                                            class="block text-sm font-medium text-gray-700 mb-1">Nombre Técnico /
                                            Key</label>
                                        <input id="nombreTecnicoCampoModal" wire:model.lazy="nombreTecnicoCampo"
                                            type="text" class="form-input w-full"
                                            placeholder="Ej: nombre_completo (opcional)">
                                        <p class="text-xs text-gray-500 mt-1">Si se omite, se generará uno. Usar solo
                                            letras, números, '_'.</p>
                                        @error('nombreTecnicoCampo')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Fila 2: Tipo de Campo y Opciones (condicional) --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="tipoCampoModal"
                                            class="block text-sm font-medium text-gray-700 mb-1">Tipo de campo <span
                                                class="text-red-500">*</span></label>
                                        <select id="tipoCampoModal" wire:model="tipoCampo" wire:change="$refresh"
                                            class="form-select w-full">
                                            <option value="text">Texto Corto (Text)</option>
                                            <option value="textarea">Texto Largo (Textarea)</option>
                                            <option value="email">Correo Electrónico (Email)</option>
                                            <option value="number">Número (Number)</option>
                                            <option value="date">Fecha (Date)</option>
                                            <option value="file">Archivo (File)</option>
                                            <option value="select">Lista Desplegable (Select)</option>
                                            <option value="radio">Opciones Radio (Radio Group)</option>
                                            <option value="checkbox">Casillas de Verificación (Checkbox Group)</option>
                                        </select>
                                        @error('tipoCampo')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    @if (in_array($tipoCampo, ['select', 'radio', 'checkbox']))
                                        <div>
                                            <label for="opcionesCampoModal"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Opciones @if (in_array($tipoCampo, ['select', 'radio', 'checkbox']))
                                                    <span class="text-red-500">*</span>
                                                @endif
                                            </label>
                                            <input id="opcionesCampoModal" wire:model.lazy="opcionesCampo"
                                                type="text" class="form-input w-full"
                                                placeholder="Opción 1, Opción 2, Opción 3">
                                            <p class="text-xs text-gray-500 mt-1">Separadas por comas.</p>
                                            @error('opcionesCampo')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endif
                                </div>

                                {{-- Fila 3: Info Adicional y Valor Predeterminado --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="infoAdicionalCampoModal"
                                            class="block text-sm font-medium text-gray-700 mb-1">Información Adicional
                                            (Ayuda)</label>
                                        <input id="infoAdicionalCampoModal" wire:model.lazy="infoAdicionalCampo"
                                            type="text" class="form-input w-full"
                                            placeholder="Texto de ayuda para el usuario">
                                        @error('infoAdicionalCampo')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="valorPredeterminadoCampoModal"
                                            class="block text-sm font-medium text-gray-700 mb-1">Valor
                                            Predeterminado</label>
                                        <input id="valorPredeterminadoCampoModal"
                                            wire:model.lazy="valorPredeterminadoCampo" type="text"
                                            class="form-input w-full" placeholder="Valor por defecto del campo">
                                        @error('valorPredeterminadoCampo')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Checkbox Requerido --}}
                                <div class="pt-2">
                                    <label for="requeridoCampoModal" class="flex items-center cursor-pointer">
                                        <input id="requeridoCampoModal" wire:model.lazy="requeridoCampo"
                                            type="checkbox"
                                            class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Este campo es obligatorio</span>
                                    </label>
                                </div>

                                <div class="flex justify-end pt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <svg wire:loading wire:target="agregarCampoPreview"
                                            class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span wire:loading.remove wire:target="agregarCampoPreview">Agregar a
                                            Lista</span>
                                        <span wire:loading wire:target="agregarCampoPreview">Agregando...</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Vista Previa de Campos --}}
                        <div class="mt-6">
                            <h3 class="text-md font-semibold text-gray-700 mb-3 border-b pb-2">
                                Campos del Paso ( <span class="text-indigo-600">{{ count($camposPreview) }}</span> )
                            </h3>
                            @if (count($camposPreview))
                                <div class="mt-2 space-y-2 max-h-72 overflow-y-auto pr-2">
                                    @foreach ($camposPreview as $index => $campo)
                                        <div wire:key="{{ $campo['id'] }}"
                                            class="bg-white rounded-md p-3 border border-gray-200 group hover:border-indigo-400 transition-all">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-800 truncate">
                                                        <span
                                                            class="text-xs text-gray-400 mr-1">#{{ $index + 1 }}</span>
                                                        {{ $campo['nombre'] }}
                                                        @if ($campo['requerido'])
                                                            <span class="text-red-500 text-xs ml-1">*</span>
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-gray-500 truncate">
                                                        <!-- Iconos para tipos de campo (Ejemplos) -->
                                                        @if ($campo['tipo'] === 'text')
                                                            <span title="Texto Corto">📝</span>
                                                        @elseif($campo['tipo'] === 'textarea')
                                                            <span title="Texto Largo">📄</span>
                                                        @elseif($campo['tipo'] === 'email')
                                                            <span title="Email">📧</span>
                                                        @elseif($campo['tipo'] === 'number')
                                                            <span title="Número">🔢</span>
                                                        @elseif($campo['tipo'] === 'date')
                                                            <span title="Fecha">📅</span>
                                                        @elseif($campo['tipo'] === 'file')
                                                            <span title="Archivo">📎</span>
                                                        @elseif($campo['tipo'] === 'select')
                                                            <span title="Selección">📋</span>
                                                        @elseif($campo['tipo'] === 'radio')
                                                            <span title="Radio">🔘</span>
                                                        @elseif($campo['tipo'] === 'checkbox')
                                                            <span title="Checkboxes">☑️</span>
                                                        @endif
                                                        <span class="capitalize">{{ $campo['tipo'] }}</span> | <span
                                                            class="font-mono text-indigo-600">{{ $campo['nombre_tecnico'] ?? 'N/A' }}</span>
                                                    </p>
                                                    @if (in_array($campo['tipo'], ['select', 'radio', 'checkbox']) && !empty($campo['opciones']))
                                                        <p class="text-xs text-gray-500 truncate"
                                                            title="{{ implode(', ', $campo['opciones']) }}">Opciones:
                                                            {{ Str::limit(implode(', ', $campo['opciones']), 30) }}</p>
                                                    @endif
                                                    @if (!empty($campo['info_adicional']))
                                                        <p class="text-xs text-gray-400 truncate"
                                                            title="{{ $campo['info_adicional'] }}">Info:
                                                            {{ Str::limit($campo['info_adicional'], 30) }}</p>
                                                    @endif
                                                    @if (!empty($campo['valor_predeterminado']))
                                                        <p class="text-xs text-gray-400 truncate"
                                                            title="{{ $campo['valor_predeterminado'] }}">Default:
                                                            {{ Str::limit($campo['valor_predeterminado'], 30) }}</p>
                                                    @endif
                                                </div>
                                                <div
                                                    class="flex items-center space-x-1 ml-2  group-hover:opacity-100 transition-opacity">
                                                    {{ $index }}
                                                    <button type="button"
                                                        wire:click="moveCampoUp({{ $index }})"
                                                        title="Mover arriba"
                                                        @if ($index === 0) disabled @endif
                                                        class="btn-icon @if ($index === 0) btn-icon-disabled @endif">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        wire:click="moveCampoDown({{ $index }})"
                                                        title="Mover abajo"
                                                        @if ($index === count($camposPreview) - 1) disabled @endif
                                                        class="btn-icon @if ($index === count($camposPreview) - 1) btn-icon-disabled @endif">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 17a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 17zm-3.707-9.293a1 1 0 011.414 0L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 010 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414 0z"
                                                                clip-rule="evenodd" transform="rotate(180 10 10)">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        wire:click="eliminarCampoPreview({{ $index }})"
                                                        title="Eliminar campo" class="btn-icon btn-icon-danger">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div
                                    class="text-center text-gray-500 py-6 border-dashed border-2 border-gray-300 rounded-md">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" aria-hidden="true">
                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2"
                                            d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay campos definidos</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comienza agregando un campo usando el
                                        formulario de arriba.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Pie del Modal: Botones de Acción Globales --}}
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                        <button type="button" wire:click="cerrarModalContenidoPasos" class="btn btn-secondary">
                            Cancelar
                        </button>
                        <button type="button" wire:click="guardarCamposDelPaso" wire:loading.attr="disabled"
                            wire:target="guardarCamposDelPaso" class="btn btn-primary">
                            <svg wire:loading wire:target="guardarCamposDelPaso"
                                class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span wire:loading.remove wire:target="guardarCamposDelPaso">Guardar Cambios</span>
                            <span wire:loading wire:target="guardarCamposDelPaso">Guardando...</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Add AlpineJS for the modal transitions if not already included globally --}}
            {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}

            {{-- Basic CSS for form elements (if not using Tailwind Forms plugin or similar) --}}
            <style>
                .form-input,
                .form-select,
                .form-checkbox {
                    @apply shadow-sm block w-full sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500;
                }

                .form-checkbox {
                    @apply h-4 w-4 text-indigo-600 border-gray-300 rounded;
                }

                .btn {
                    @apply inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2;
                }

                .btn-primary {
                    @apply text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500;
                }

                .btn-secondary {
                    @apply text-gray-700 bg-white hover:bg-gray-50 border-gray-300 focus:ring-indigo-500;
                }

                .btn-icon {
                    @apply p-1 text-gray-500 hover:text-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors;
                }

                .btn-icon-danger {
                    @apply hover:text-red-700 focus:ring-red-400;
                }

                .btn-icon-disabled {
                    @apply opacity-50 cursor-not-allowed hover:text-gray-500;
                }
            </style>
        @endif

        {{-- END --}}


    </div>


</div>

<script>
    Livewire.on('refresh', () => {
        // Esto asegura que Livewire recargue el componente para reflejar cualquier cambio
        $wire.dispatch('render');
    });
</script>
