@php

    $config = app(App\Services\ConfigService::class);

    $config->clearCache();
@endphp


<div class="grid gap-4">

    <aside class="col-span-1 bg-gray-800 text-white h-screen p-4 rounded-2xl">

        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Trámites disponibles</h2>
                <button wire:click="abrirModal2" class="bg-green-600 text-white px-4 py-2 rounded">Registrar nuevo
                    trámite</button>
            </div>

            <table class="table table-light  w-full table-auto border-collapse border text-black border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Nombre</th>
                        <th class="border p-2">Código</th>
                        <th class="border p-2">Activo</th>
                        <th class="border p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($tramites as $tramite)
                        <tr>
                            <td class="border p-2">{{ $tramite->nombre }}</td>
                            <td class="border p-2">{{ $tramite->code }}</td>
                            <td class="border p-2">{{ $tramite->active ? 'Sí' : 'No' }}</td>
                            <td class="border p-2 flex gap-2">
                                <button wire:click="verResumenTramite({{ $tramite->id }})"
                                    class="text-black hover:underline">Resumen</button>
                                <button wire:click="editar({{ $tramite->id }})"
                                    class="text-blue-600 hover:underline">Editar</button>
                                <button wire:click="eliminar({{ $tramite->id }})"
                                    class="text-red-600 hover:underline">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Modal --}}
            @if ($showModal)
                <div class="fixed  text-black inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                        <h3 class="text-xl font-semibold mb-4">
                            {{ $modoEditar ? 'Editar trámite' : 'Registrar nuevo trámite' }}
                        </h3>

                        <form wire:submit.prevent="guardar">
                            <div class="mb-4">
                                <label class="block font-medium">Nombre</label>
                                <input type="text" wire:model.defer="nombre" class="w-full border rounded p-2">
                                @error('nombre')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block font-medium">Código</label>
                                <p><strong>el codigo debe definir el tramite en una sola palabra</strong></p>
                                <input type="text" wire:model.defer="code" class="w-full border rounded p-2">
                                @error('code')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" wire:model.defer="active">
                                    <span>Trámite activo</span>
                                </label>
                            </div>

                            <div class="flex justify-end space-x-2">
                                <button type="button" wire:click="cerrarModal"
                                    class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                                    {{ $modoEditar ? 'Actualizar' : 'Guardar' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            {{-- Modal resumen tramite --}}
            @if ($showModalResumen)
                <div class="fixed text-black inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-6xl max-h-[90vh] overflow-y-auto p-8">
                        {{-- Header --}}
                        <h3 class="text-2xl font-semibold mb-6">Resumen del Trámite: {{ $nombre }}</h3>
                        <h2>{{ $id }}</h2>

                        {{-- Resumen --}}
                     
                        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div><strong>Código:</strong> {{ $code }}</div>
                            <div><strong>Activo:</strong> {{ $active ? 'Sí' : 'No' }}</div>
                        </div>

                        <hr class="my-6">

                        {{-- CRUD de formatos --}}
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <h4 class="text-xl font-bold">Formatos del trámite</h4>
                                <button wire:click="verFormatoTramite({{ $tramite->id }})"
                                    class="bg-blue-600 text-white px-4 py-2 rounded">
                                    Nuevo formato
                                </button>
                            </div>

                            <table class="w-full table-auto border-collapse border border-gray-300">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border p-2">Nombre</th>
                                        <th class="border p-2">Descripción</th>
                                        <th class="border p-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($formatos as $formato)
                                        <tr>
                                            <td class="border p-2">{{ $formato->nombre_formato }}</td>
                                            <td class="border p-2">{{ $formato->descripcion }}</td>
                                            <td class="border p-2">
                                                <button wire:click="crearSecciones({{ $formato->id }})"
                                                    class="text-dark">Crear contenido</button>
                                                <button wire:click="editarFormato({{ $formato->id }})"
                                                    class="text-blue-600">Editar</button>
                                                <button wire:click="eliminarFormato({{ $formato->id }})"
                                                    class="text-red-600 ml-2">Eliminar</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center p-4">No hay formatos registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="flex justify-end space-x-2">
                                <button type="button" wire:click="cerrarModalResumen"
                                    class="px-4 py-2 bg-gray-300 rounded">Cerrar</button>
                            </div>
                        </div>

                        {{-- Modal interno para crear/editar formatos --}}
                        @if ($showModalFormato)
                            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white p-6 rounded-lg w-full max-w-lg shadow-lg">
                                    <h4 class="text-lg font-bold mb-4">
                                        {{ $modoEditarFormato ? 'Editar formato' : 'Nuevo formato' }}
                                    </h4>


                                    <form wire:submit.prevent="guardarFormato">
                                        <div class="mb-4">
                                            <label class="block mb-1 font-medium">Nombre</label>
                                            <input type="text" wire:model.defer="formatoNombre"
                                                class="w-full border rounded p-2">
                                            @error('formatoNombre')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label class="block mb-1 font-medium">Descripción</label>
                                            <textarea wire:model.defer="formatoDescripcion" class="w-full border rounded p-2"></textarea>
                                            @error('formatoDescripcion')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="flex justify-end space-x-2">
                                            <button type="button" wire:click="cerrarModalFormato"
                                                class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                                            <button type="submit"
                                                class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif



                    </div>
                </div>
            @endif





        </div>


    </aside>




</div>
