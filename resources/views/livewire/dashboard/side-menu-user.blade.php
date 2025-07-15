<div class="space-y-2">
    <a
        href="{{ route('dashboard') }}"
        @click.prevent="loading = true; window.location.href = '{{ route('dashboard') }}'"
        class="block px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-400 text-gray-800 dark:text-gray-200 font-semibold hover:bg-[#BC955C] hover:text-white transition-all duration-200">
        Inicio
    </a>

    <a
        href="{{ route('tramites.usuario') }}"
        @click.prevent="loading = true; window.location.href = '{{ route('tramites.usuario') }}'"
        class="block px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-400 text-gray-800 dark:text-gray-200 font-semibold hover:bg-[#BC955C] hover:text-white transition-all duration-200">
        Mis Trámites
    </a>
</div>
