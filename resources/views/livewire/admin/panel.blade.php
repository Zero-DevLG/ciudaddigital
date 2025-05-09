{{-- <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md p-4">
        <ul class="space-y-4">
            <li>
                <button wire:click="cambiarVista('configuracion')" class="hover:underline">Configuración</button>
            </li>
            <li>
                <button wire:click="cambiarVista('configuracion')" class="hover:underline">Secciones</button>
            </li>
            <li>
                <button wire:click="cambiarVista('usuarios')" class="hover:underline">Usuarios</button>
            </li>
            <li>
                <button wire:click="cambiarVista('tramites')" class="hover:underline">Tramites</button>
            </li>
        </ul>
    </aside>

    <!-- Contenido -->
    <main class="flex-1 p-6">
        @if ($vistaActiva === 'configuracion')
            @livewire('admin.configuracion')
        @elseif ($vistaActiva === 'usuarios')
            @livewire('admin.usuarios')
        @endif
    </main>
</div> --}}

@php

    $config = app(App\Services\ConfigService::class);

    $config->clearCache();

@endphp



<div class="flex min-h-screen main-container">

    <aside class="w-64 bg-gray-900 text-gray-100 min-h-screen px-6 py-8 shadow-md">
        <!-- Logo -->
        <div class="flex flex-col items-center mb-10">
            <div class="flex justify-center items-center w-[150px] h-[80px] bg-white rounded-lg">
                <img src="{{ asset($config->get('logo', 'img/default.png')) }}" class="h-10 " alt="Logo">
            </div>
            <span class="text-xl font-semibold mt-2">Administrador</span>
        </div>

        <!-- Navegación -->
        <nav class="space-y-2">
            <button wire:click="changeView('dashboard')" @disabled($vistaActiva === 'dashboard')
                class="w-full flex items-center px-4 py-2 rounded-md hover:bg-gray-800 transition-all {{ $vistaActiva === 'dashboard' ? 'bg-gray-800' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6"></path>
                </svg>
                Dashboard
            </button>

            <button wire:click="changeView('configuracion')" @disabled($vistaActiva === 'configuracion')
                class="w-full flex items-center px-4 py-2 rounded-md hover:bg-gray-800 transition-all {{ $vistaActiva === 'configuracion' ? 'bg-gray-800' : '' }}">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACFUlEQVR4nO2az0oCURTGB/cq1kYL2kRt6j0q2giSj5AvoPkQ+Rq5raBXCSLBRYELVykGuekXh24lNN754/0zTn1wYeCeOZyPOefc+x0mCP7xRwGcAK/8QJ6Pg3UD0Oc3roJ1AVAAToFxCJGx2isEa5BOA6IxyFSaAS3gDugCPeCd+BDbnnpXfLR8kdgF3jCHObDvg8gt5nHjmsQh9nDgkkgZGFogMRTfzogoMjvASBOU1E8bqKnViaipkfh0SmKBzL0msHaI/YXG/t4LCRXYVBNYNcS+qrGf+mHxGdhEE1gtxH5bY//ih0V0anVC7OXwy1ZqEa/YpSa21OqqQy87xU5e2i95ORAFcp2wQOI6cK3wgL2InE+Kufh0pfD6hq/xlwvX+PPMKDz5YjGF1SNwZDRw0wrPi9TFosKLk5pGYLtYVZrNFvZnX1/R6KgIjwrP2KgITwea8frBwxXD2qgIywrP6agISwrP+amPJYXnvJGQXOGJrliGibdGggWFF7ORPAENoKhWHXhI1UhsKrwI30JiIySeitrT+nbefjVfu6FJ9bNEet5FHmvqr6ghUtLVn0uF991ZUhIppyFi+9K4LLXqmpiaqUZFthReRLFLd6qExLIJPBsZFZlQeAnarxR2Sa2mhkS6UdGqN9TMjYpYQTNkalSERuHFeHc9RkVxkOlR0SrIzKjIBHLxV0Su/lMx0UiCvOEDwkPPN8uqFkUAAAAASUVORK5CYII="
                    alt="gears" class="w-5 h-5 mr-3">

                Configuración
            </button>

            <button wire:click="changeView('tramites')" @disabled($vistaActiva === 'tramites')
                class="w-full flex items-center px-4 py-2 rounded-md hover:bg-gray-800 transition-all {{ $vistaActiva === 'tramites' ? 'bg-gray-800' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 16h8M8 12h8m-6 8h6a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2h2"></path>
                </svg>
                Tramites
            </button>


            <button wire:click="changeView('usuarios')" @disabled($vistaActiva === 'usuarios')
                class="w-full flex items-center px-4 py-2 rounded-md hover:bg-gray-800 transition-all {{ $vistaActiva === 'usuarios' ? 'bg-gray-800' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5.121 17.804A4 4 0 0112 20a4 4 0 016.879-2.196M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Usuarios
            </button>


            <button wire:click="changeView('secciones')" @disabled($vistaActiva === 'secciones')
                class="w-full flex items-center px-4 py-2 rounded-md hover:bg-gray-800 transition-all {{ $vistaActiva === 'secciones' ? 'bg-gray-800' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h7v7H3V3zm11 0h7v7h-7V3zm-11 8h7v7H3v-7zm11 0h7v7h-7v-7z"></path>
                </svg>
                Secciones
            </button>


        </nav>


        <div class="mt-auto pt-6 border-t border-gray-700 text-sm">
            <p class="text-gray-400">Versión 1.0</p>
        </div>
    </aside>


    <!-- Contenido -->
    <main class="flex-1 p-6">
        @if ($vistaActiva === '')
            <p class="text-gray-500">Cargando vista...</p>
        @else
            @switch($vistaActiva)
                @case('configuracion')
                    @livewire('admin.configuracion')
                @break

                @case('usuarios')
                    @livewire('admin.usuarios')
                @break

                @case('tramites')
                    @livewire('admin.tramites-crud')
                @break

                @case('secciones')
                    @livewire('admin.secciones')
                @break
            @endswitch
        @endif
    </main>

</div>
