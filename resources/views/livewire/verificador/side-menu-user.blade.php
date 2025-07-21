<script src="https://unpkg.com/lucide@latest"></script>


<div class="space-y-1 p-2">
    <a
        href="{{ route('dashboard_verificador') }}"
        @click.prevent="loading = true; window.location.href = '{{ route('dashboard') }}'"
        class="flex items-center gap-2 px-3 py-2 border border-1 border-gray-500 rounded-md  text-gray-500 dark:text-gray-500 text-sm hover:bg-[#F0F4F8]  transition-all duration-200"
    >
        <i data-lucide="folder" class="w-4 h-4"></i>
        <span>Tramites asignados</span>
    </a>

</div>

<script>
    lucide.createIcons(); // Importante: renderiza los íconos
</script>
