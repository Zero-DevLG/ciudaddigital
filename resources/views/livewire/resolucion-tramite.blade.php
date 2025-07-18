<div>
    <h2 class="text-2xl font-extrabold text-[#9D2449] mb-6 border-b pb-2">
        Resolución del Trámite
    </h2>

    {{-- Select con catálogo de resoluciones --}}
    <div class="mb-6">
        <label for="tipo_resolucion" class="block font-semibold text-gray-800 mb-2">
            Tipo de resolución
        </label>
        <select id="tipo_resolucion" wire:model="tipoResolucionSeleccionada"
            class="w-full border border-gray-300 rounded-md shadow-sm p-3 text-gray-700 focus:ring-[#9D2449] focus:border-[#9D2449] transition">
            <option value="">— Selecciona un tipo —</option>
            @foreach ($catalogoResoluciones as $resolucion)
                @if ($resolucion->nombre !== 'Prevención' || !$resolucion_prevencion)
                    <option value="{{ $resolucion->id }}">{{ $resolucion->nombre }}</option>
                @endif
            @endforeach
        </select>
    </div>

    {{-- Motivo de la resolución --}}
    <div class="mb-6">
        <label for="motivo_resolucion" class="block font-semibold text-gray-800 mb-2">
            Motivo de la resolución
        </label>
        <textarea
            id="motivo_resolucion"
            wire:model="motivoResolucion"
            rows="6"
            class="w-full border border-gray-300 rounded-md shadow-sm p-3 text-gray-700 focus:ring-[#9D2449] focus:border-[#9D2449] transition resize-y"
            placeholder="Describe el motivo o detalles de la resolución aquí..."></textarea>
    </div>

    {{-- Botón vista previa --}}
    <button
        wire:click="toggleVistaPrevia"
        class="bg-[#9D2449] hover:bg-[#7B1C39] text-white font-bold px-6 py-3 rounded-md shadow-md transition"
    >
        {{ $mostrarVistaPrevia ? 'Ocultar vista previa' : 'Vista previa' }}
    </button>

    {{-- Vista previa PDF --}}
    @if($mostrarVistaPrevia)
        <div class="mt-8 border rounded-md shadow-inner overflow-hidden" style="height: 600px;">
            <iframe
                src="{{ asset($rutaPdf) }}"
                class="w-full h-full"
                frameborder="0"
                loading="lazy"
                title="Vista previa de la resolución PDF"
            ></iframe>
        </div>
    @endif
</div>
