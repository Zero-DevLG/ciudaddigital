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
                                <button>Crear </button>
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

    </div>


</div>
