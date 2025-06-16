<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-400 leading-tight">
            {{ __('Panel principal') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal que ocupa toda la pantalla restante después del header --}}
    <div style="background-color: #eae8de;" class="flex h-[calc(100vh-4rem)] overflow-hidden px-4 py-4 gap-6">
        {{-- Sidebar fijo al 20% --}}
        <aside class="w-1/5 min-w-[220px] max-w-xs bg-white dark:bg-gray-800 p-4 rounded-lg shadow overflow-y-auto">
            <livewire:dashboard.side-menu-user />
        </aside>

        {{-- Contenido principal --}}
        <main class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow overflow-y-auto flex flex-col">
            <livewire:tramite_uso_suelo />
        </main>
    </div>
</x-app-layout>
