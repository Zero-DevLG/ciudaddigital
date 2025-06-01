<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-400 leading-tight">
            {{ __('Panel principal') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal que ocupa toda la pantalla restante después del header --}}
    <div style="background-color: #eae8de;" class="flex h-[calc(100vh-4rem)] overflow-hidden px-4 py-4">

        {{-- Sidebar fijo al 20% --}}
        <div class="w-1/5 bg-white dark:bg-gray-800 p-4 rounded-lg shadow overflow-y-auto">
            <livewire:dashboard.side-menu-user />
        </div>

        {{-- Contenido principal con scroll si es necesario --}}
        <div class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow ml-4 overflow-y-auto">
             <livewire:tramite-wizard :tramite="$tramite" />
        </div>

    </div>
</x-app-layout>
