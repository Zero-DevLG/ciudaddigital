<div class="p-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg">
    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-500 mb-6 text-center">Selecciona un trámite para iniciar:
    </h2>
    <hr>

    <br>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($tramites as $tramite)
            <a href="{{ route('tramite.iniciar', $tramite->id) }}"
                class="p-6 bg-white  rounded-lg shadow hover:shadow-md transition hover:scale-105 transform duration-200 text-center border border-gray-300 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-400">{{ $tramite->nombre }}</h3>
            </a>
        @empty
            <p class="text-gray-600 dark:text-gray-300 col-span-full text-center">No hay trámites disponibles aún.</p>
        @endforelse
    </div>
</div>
