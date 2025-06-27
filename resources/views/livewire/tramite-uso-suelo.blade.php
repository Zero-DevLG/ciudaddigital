<div>
    <div class="flex items-center justify-between mb-6">
        <button wire:click="pasoAnterior" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
            @disabled($pasoActual == 0)>
            ← Atrás
        </button>
        <span class="text-lg font-semibold">Paso {{ $pasoActual + 1 }} de {{ count($pasos) }}</span>
        <button wire:click="guardarDatosHijoActivo" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
            @disabled($pasoActual == count($pasos) - 1)>
            Siguiente →
        </button>
    </div>

    <div>
        @if ($pasoActual === 0)
            <livewire:usosuelo.datos-solicitante :tramiteId="$tramiteId" />
        @elseif ($pasoActual === 1)
            <livewire:usosuelo.datos-propiedad :tramiteId="$tramiteId" />
        @elseif ($pasoActual === 2)
            <livewire:caracteristicas_proyecto :tramiteId="$tramiteId" />
        @elseif ($pasoActual === 3)
            <livewire:documentacion-solicitante-form :tramiteId="$tramiteId" />
        @endif


    </div>
</div>


@script
    <script>
        $wire.on('pasoCambiado', () => {
            // Aquí puedes manejar cualquier lógica adicional cuando el paso cambie
            console.log('Paso cambiado a:', $wire.get('pasoActual'));
            if ($wire.get('pasoActual') === 1) {
                console.log('dispatching tests event');
                $wire.dispatch('tests');
            }
        });
    </script>
@endscript
