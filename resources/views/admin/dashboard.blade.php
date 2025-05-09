<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de administración
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        {{-- Aquí carga el panel dinámico Livewire --}}
        <livewire:admin.panel />
    </div>
</x-app-layout>
