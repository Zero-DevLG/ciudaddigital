<div class="p-6 bg-white rounded-lg shadow-md space-y-4">

    {{-- Info del trámite --}}
    <div class="text-sm text-gray-600">
        <strong>ID del trámite:</strong> {{ $tramite_id }}
    </div>
    <h1 class="text-xl font-bold text-[#9D2449] mb-4">{{ $tipo_tramite->nombre }}</h1>
    <h6 class="font-bold text-[#9D2449] mb-4">{{ $tramite->folio }}</h6>
    <p class="text-gray-600 mb-4">Fecha de inicio: <span class="font-semibold">{{ $tramite->tramite_inicio }}</span></p>

    {{-- Instrucciones --}}
    <div class="mb-6 p-4 bg-[#E6F0FA] border-l-4 border-[#3B82F6] rounded shadow-sm">
        <h2 class="text-[#1E3A8A] font-semibold text-lg mb-1">Guía para completar el trámite</h2>
        <ul class="text-sm text-gray-800 list-disc list-inside space-y-1">
            <li>Completa cada paso en orden.</li>
            <li>Verifica cuidadosamente los datos ingresados.</li>
            <li>Llena los campos obligatorios.</li>
            <li>Guarda tus avances si es posible.</li>
            <li>Consulta al área de soporte en caso de dudas.</li>
        </ul>
    </div>

    <hr>

    {{-- Ciclo dinámico de pasos --}}
    @foreach ($pasos_puntero as $paso)
        <div x-data="{ open: false }" class="mb-6 border border-gray-200 rounded-lg shadow-sm bg-white">
            <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between text-left bg-[#F3EDE9] hover:bg-[#e7d4cb] transition-colors duration-200 rounded-t-md">
                <span class="text-[#9D2449] font-semibold text-lg">
                    Paso {{ $paso->n_paso }}: {{ ucwords(str_replace('_', ' ', $paso->nombre_paso)) }}
                </span>
                <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
                <svg x-show="open" x-cloak class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                </svg>
            </button>

            <div x-show="open" x-collapse class="px-6 py-4 text-sm text-gray-800 bg-white border-t border-gray-200">
                <livewire:paso-formulario-revision
                    :nombrePaso="$paso->nombre_paso"
                    :tramiteId="$tramite_id"
                    :pasoId="$paso->id"
                    wire:key="'paso-'.$paso->id"
                />

                <livewire:validacion-paso
                    :tramiteId="$tramite_id"
                    :pasoId="$paso->id"
                    wire:key="'validacion-'.$paso->id"
                />
            </div>
        </div>
    @endforeach

    {{-- Continuar a resolución --}}
    <div x-data="{ abierto: false }" class="mb-4 border rounded shadow">
        <div class="flex items-center justify-between bg-gray-100 px-4 py-2 cursor-pointer" @click="abierto = !abierto">
            <h3 class="text-lg font-semibold text-gray-800">Resolución</h3>
            <svg :class="{'rotate-180': abierto}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <div x-show="abierto" x-transition class="p-4">
            {{-- Aquí va el contenido de la resolución --}}
            <div class="text-gray-700">
                <livewire:resolucion-tramite :tramite-id="$tramite_id" />
            </div>
        </div>
    </div>

</div>
