<div>
     {{-- Sección 4: Documentos Adjuntos --}}
    <section class="border rounded-md p-6 bg-white">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Documentos Adjuntos</h2>
        <ul class="list-disc list-inside text-gray-700">
            @forelse ($documentos_tramite as $documento)
                <li>
                    <a href="{{ asset('storage/' . $documento->url) }}" class="text-indigo-600 underline" target="_blank">{{ $documento->nombre_documento }}</a>
                </li>
            @empty
                <li class="text-gray-500">No se han adjuntado documentos</li>
            @endforelse
    </section>
</div>
