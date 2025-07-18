<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <p class="text-xl font-bold text-[#9D2449] uppercase">

            </p>
            <hr class="border-gray-300">
            <div>
                <livewire:flujo-pasos-tramite :tipoTramiteId="$tramite->tipo_tramite_id" />
            </div>
        </div>
    </x-slot>

    <div class="bg-[#f8f8f8] flex h-[calc(100vh-4rem)] overflow-hidden px-4 py-4 gap-6">
        <!-- Sidebar -->
        <aside class="w-1/5 min-w-[220px] max-w-xs bg-white p-4 rounded-2xl shadow-md overflow-y-auto">
            <livewire:dashboard.side-menu-user />
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="w-[90%] bg-white p-8 rounded-2xl shadow-lg border border-gray-200 mt-0">

                <!-- Título y descripción -->
                <h2 class="text-2xl font-semibold text-gray-800">Resumen del Trámite</h2>
                <p class="text-gray-600">
                    La solicitud del tramite se generó y se guardó correctamente.
                </p>
                <p class="text-gray-600">
                    Podra ver el estado de su tramite desde la sección <strong>"Mis tramites"</strong>, o usando el codigo QR en el documento de solitud.
                </p>

                <!-- Folio generado -->
                <div class="bg-white p-4 rounded-lg border border-blue-100 shadow-sm mt-4">
                    <p class="text-sm text-gray-500">Folio generado:</p>
                    <p class="text-xl font-bold text-[#9D2449] tracking-widest">{{ $folio }}</p>
                </div>

                <!-- Acciones -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                    <a href="{{ asset('storage/' . $file->url) }}"
                       class="inline-block px-6 py-3 bg-[#9D2449] hover:bg-[#9D2449] text-white font-medium text-sm rounded-lg shadow transition"
                       target="_blank">
                        Descargar PDF
                    </a>

                    <a href="{{ route('tramites.usuario') }}"
                       class="inline-block px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium text-sm rounded-lg shadow transition">
                        Volver a mis trámites
                    </a>
                </div>

            </div>
        </main>
    </div>
</x-app-layout>
