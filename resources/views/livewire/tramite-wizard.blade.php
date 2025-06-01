<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Trámite: {{ $tramite->nombre }}</h2>

    @if ($paso)
        <div class="mb-4">
            <h3 class="text-lg font-semibold">Paso {{ $pasoActual + 1 }}: {{ $paso->titulo }}</h3>
            <h2 class="text-gray-600">{{ $paso->descripcion }}</h2>

            <!-- Aquí renderizas campos dinámicos -->
            <hr>

            @foreach ($paso->campos as $campo)

                <div class="my-2">
                    <label class="block text-sm font-medium">{{ $campo->nombre_campo }}</label>
                    @if ($campo->tipo === 'text')
                        <input type="text" wire:model.defer="data.{{ $campo->nombre_campo }}" class="form-input w-full" />
                    @elseif ($campo->tipo === 'file')
                        <input type="file" wire:model="data.{{ $campo->nombre }}" class="form-input w-full" />
                    @elseif($campo->tipo === 'date')
                         <input type="date" wire:model="data.{{ $campo->nombre }}" class="form-input w-full" />
                    @elseif ($campo->tipo === 'select')
                        <select wire:model="data.{{ $campo->nombre }}" class="form-select w-full">
                            @foreach (json_decode($campo->opciones) as $opcion)
                                <option value="{{ $opcion }}">{{ $opcion }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Navegación entre pasos -->
        <div class="flex justify-between mt-6">
            @if($pasoActual > 0)
        <button wire:click="pasoAnterior" class="btn">Anterior</button>
    @endif

    @if($pasoActual < count($pasos) - 1)
        <button wire:click="siguientePaso" class="btn btn-primary">Siguiente</button>
    @else
        <button wire:click="finalizar" class="btn btn-success">Finalizar</button>
    @endif
        </div>
    @else
        <p>No hay pasos definidos para este trámite.</p>
    @endif
</div>
