<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">

            <!-- Título principal compacto -->


            <!-- Nombre del trámite en azul minimalista -->
            <p class="text-xl font-bold uppercase text-[#9D2449]">
                {{ $tramite_tipo->nombre ?? 'Nombre del trámite' }}
            </p>

            <hr>

            <!-- Flujo de pasos del trámite -->
            <div>
                <livewire:flujo-pasos-tramite :tipoTramiteId="1" />
            </div>

        </div>
    </x-slot>




    {{-- Contenedor principal que ocupa toda la pantalla restante después del header --}}
    <div style="background-color: #eae8de;" class="flex h-[calc(100vh-4rem)] overflow-hidden px-4 py-4 gap-6">
        {{-- Sidebar fijo al 20% --}}
        <aside class="w-1/5 min-w-[220px] max-w-xs bg-white dark:bg-gray-800 p-4 rounded-lg shadow overflow-y-auto">
            <livewire:dashboard.side-menu-user />
        </aside>

        {{-- Contenido principal --}}
        <main class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow overflow-y-auto flex flex-col">


            <livewire:tramite_uso_suelo :tramite="$tramite" :tramite_tipo="$tramite_tipo" :pasos_puntero="$pasos_puntero" />
        </main>
    </div>
</x-app-layout>
