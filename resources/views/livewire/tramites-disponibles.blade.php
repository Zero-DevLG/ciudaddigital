<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>


<div class="p-6 bg-white dark:bg-gray-900 shadow-sm rounded-xl">
    <h3 class=" font-bold text-gray-600  mb-4 text-center">
        Selecciona un trámite para iniciar
    </h3>
    <h6 class="text-gray-500 text-center mb-6">
        Elige el trámite que deseas comenzar. Haz clic para iniciar el proceso.
    </h6>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse ($tramites as $tramite)
            <a href="{{ route('tramite.iniciar', $tramite->id) }}"
                class="no-underline group bg-white border border-gray-300
                rounded-lg p-5 shadow-sm hover:shadow-md transition hover:scale-[1.02] duration-200 hover:border-[#BC955C]">

                <div class="flex items-center justify-center mb-4">
                    <div class="bg-[#BC955C]/10 text-[#BC955C] p-3 rounded-full">
                        <i data-lucide="file-text" class="w-6 h-6"></i>
                    </div>
                </div>

                <h3 class="text-center text-base font-semibold text-gray-800 group-hover:text-[#BC955C]">
                    {{ ucfirst(str_replace('_', ' ', strtolower($tramite->nombre))) }}
                </h3>
            </a>
        @empty
            <div class="col-span-full text-center text-gray-500 dark:text-gray-400 py-6">
                <i data-lucide="x-circle" class="w-6 h-6 inline-block mr-1"></i>
                No hay trámites disponibles aún.
            </div>
        @endforelse
    </div>
</div>
