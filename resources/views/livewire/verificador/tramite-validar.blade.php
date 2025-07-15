<div class="p-6 bg-white rounded-lg shadow-md space-y-4">

    {{-- ID del trámite --}}
    <div class="text-sm text-gray-600">
        <strong>ID del trámite:</strong> {{ $tramite_id }}
    </div>

    <h1 class="text-xl font-bold text-[#9D2449] mb-4">{{ $tipo_tramite->nombre }}</h1>
    <h6 class="font-bold text-[#9D2449] mb-4">{{ $tramite->folio }}</h6>

    <p class="text-gray-600 mb-4">Fecha de inicio: <span class="font-semibold">{{ $tramite->tramite_inicio }}</span></p>

    {{-- Nota de instrucciones --}}
    <div class="mb-6 p-4 bg-[#E6F0FA] border-l-4 border-[#3B82F6] rounded shadow-sm">
        <h2 class="text-[#1E3A8A] font-semibold text-lg mb-1">Guía para completar el trámite</h2>
        <ul class="text-sm text-gray-800 list-disc list-inside space-y-1">
            <li>Completa cada paso en orden. Puedes desplegar y contraer cada sección para enfocarte en una a la vez.</li>
            <li>Verifica cuidadosamente los datos ingresados antes de continuar al siguiente paso.</li>
            <li>Algunos campos son obligatorios, asegúrate de llenarlos para evitar errores.</li>
            <li>Guarda tus avances si el sistema lo permite, y no cierres la ventana sin hacerlo.</li>
            <li>Si tienes dudas, contacta al área de soporte o consulta la ayuda disponible.</li>
        </ul>
    </div>

    <hr>

    @foreach ($pasos_puntero as $paso)
        <div x-data="{ open: false }" class="mb-6 border border-gray-200 rounded-lg shadow-sm bg-white">
            <button @click="open = !open"
                    class="w-full px-6 py-4 flex items-center justify-between text-left bg-[#F3EDE9] hover:bg-[#e7d4cb] transition-colors duration-200 rounded-t-md">
                <span class="text-[#9D2449] font-semibold text-lg">
                    Paso {{ $paso->n_paso }}: {{ Str::headline(str_replace('_', ' ', $paso->nombre_paso)) }}
                </span>
                <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7"/>
                </svg>
                <svg x-show="open" x-cloak class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 15l7-7 7 7"/>
                </svg>
            </button>

            <div x-show="open" x-collapse class="px-6 py-4 text-sm text-gray-800 bg-white border-t border-gray-200">
                @switch($paso->nombre_paso)
                    @case('datos_personales_solicitante')
                        <h1>TEST 1</h1>
                        @break

                    @case('datos_propiedad')
                        <h1>TEST 2</h1>
                        @break

                    @case('caracteristicas_proyecto')
                        <h1>TEST 3</h1>
                        @break

                    @case('documentacion_requerida')
                        <h1>TEST 4</h1>
                        @break

                    @default
                        <p class="italic text-gray-500">Este paso aún no tiene contenido asignado.</p>
                @endswitch
            </div>
        </div>
    @endforeach

    <hr>

    {{-- Sección colapsable: Generar resolución --}}
    <div x-data="{ open: false }" class="mb-6 border border-gray-200 rounded-lg shadow-sm bg-white">
    <button @click="open = !open"
            class="w-full px-6 py-4 flex items-center justify-between text-left bg-gray-100 hover:bg-gray-200 transition-colors duration-200 rounded-t-md">
        <span class="text-gray-800 font-semibold text-lg">
            Generar resolución
        </span>
        <svg x-show="!open" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7"/>
        </svg>
        <svg x-show="open" x-cloak class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 15l7-7 7 7"/>
        </svg>
    </button>

    <div x-show="open" x-collapse class="px-6 py-4 text-sm text-gray-800 bg-gray-50 border-t border-gray-200">
        <h1 class="text-gray-800 font-semibold text-base mb-2">Generar resolución</h1>
        <p class="text-sm text-gray-600">
            Asegúrate de validar todos los pasos. Cada sección contiene información importante para generar la resolución del tramite.
        </p>

        {{-- Aquí podrías agregar un botón o acción más adelante --}}
        <div class="mt-4">
            <button class="bg-[#9D2449] hover:bg-[#7B1C39] text-white px-4 py-2 rounded text-sm font-semibold shadow">
                Continuar a resolución
            </button>
        </div>
    </div>
    </div>

    <div class="flex justify-end space-x-4 mt-6">
        <button wire:click="volver" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition-colors">
            Volver
        </button>
        <button wire:click="siguiente" class="px-4 py-2 bg-[#9D2449] text-white rounded hover:bg-[#7A1F3B] transition-colors">
            Siguiente
        </button>

</div>
