<x-app-layout>


    {{-- Contenedor principal que ocupa toda la pantalla restante después del header --}}
    <div style="background-color: #F0F4F8;" class="flex h-[calc(100vh-4rem)] overflow-hidden px-4 py-4">

        {{-- Sidebar fijo al 20% --}}
        <div class="w-1/5 bg-white dark:bg-gray-800 p-4 rounded-lg shadow overflow-y-auto">
            <livewire:verificador.side-menu-user />
        </div>


        {{-- Contenido principal con scroll si es necesario --}}
        <div class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow ml-4 overflow-y-auto">
            <livewire:verificador.tramite-validar :tramiteId="$tramite->id" />

        </div>

    </div>
</x-app-layout>
