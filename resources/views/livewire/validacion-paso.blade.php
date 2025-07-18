@php
    $uid = 'paso_' . $pasoId;
@endphp

<div id="validacion-box-{{ $uid }}" class="bg-white border border-gray-300 p-4 rounded-md shadow-sm">
    <h3 class="font-semibold text-gray-700 mb-4">Validación del verificador</h3>

    {{-- Select para elegir validez --}}
    <div class="mb-4">
        <label for="validez-{{ $uid }}" class="block text-sm font-medium text-gray-700 mb-1">Resultado de la validación</label>
        <select wire:model="es_valido" id="validez-{{ $uid }}"
            class="w-full border border-gray-300 rounded-md shadow-sm text-sm p-2 focus:ring-[#9D2449] focus:border-[#9D2449]">
            <option value="">— Selecciona una opción —</option>
            <option value="1">Información válida</option>
            <option value="0">Información incorrecta</option>
        </select>
    </div>

    {{-- Observaciones --}}
    <div class="mb-4">
        <label for="observaciones-{{ $uid }}" class="block text-sm font-medium text-gray-700 mb-1">Observaciones:</label>
        <textarea wire:model.defer="observaciones" id="observaciones-{{ $uid }}" rows="4"
            class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-[#9D2449] focus:border-[#9D2449] text-sm p-2"
            placeholder="Describe las inconsistencias o errores encontrados."></textarea>
    </div>

    {{-- Botón --}}
    <button id="save-{{ $uid }}" class="bg-[#9D2449] text-white px-4 py-2 rounded-md hover:bg-[#801d3a] transition">
        Guardar validación
    </button>

    @if ($mensajeExito)
        <p class="mt-3 text-sm text-green-600 font-medium">{{ $mensajeExito }}</p>
    @endif
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log('Script de validación cargado');

    function iniciarValidacion(pasoId, tramiteId) {
        const uid = 'paso_' + pasoId;
        const box = document.getElementById('validacion-box-' + uid);
        const validezSelect = document.getElementById('validez-' + uid);
        const observacionesTextarea = document.getElementById('observaciones-' + uid);
        const saveButton = document.getElementById('save-' + uid);

        function actualizarColorFondo(esValido) {
            if (!box) return;
            box.classList.remove('bg-white', 'bg-green-100', 'bg-red-100');
            if (esValido === "1") {
                box.classList.add('bg-green-100');
            } else if (esValido === "0") {
                box.classList.add('bg-red-100');
            } else {
                box.classList.add('bg-white');
            }
        }

        // Cargar datos
        const formData = new FormData();
        formData.append('tramite_id', tramiteId);
        formData.append('paso_id', pasoId);

        fetch('/validaciones/obtener', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Datos obtenidos para paso:', pasoId, data);
            const prevencion = data.prevencion;

            if (prevencion) {
                if (observacionesTextarea && prevencion.observaciones) {
                    observacionesTextarea.value = prevencion.observaciones;
                }
                if (validezSelect) {
                    validezSelect.value = prevencion.es_valido;
                }
                actualizarColorFondo(prevencion.es_valido.toString());
            } else {
                if (validezSelect) validezSelect.value = '';
                if (observacionesTextarea) observacionesTextarea.value = '';
                actualizarColorFondo(null);
            }
        })
        .catch(error => console.error('Error al obtener validación:', error));

        // Guardar validación
        if (saveButton) {
            saveButton.addEventListener('click', function () {
                const es_valido = validezSelect?.value;
                const observaciones = observacionesTextarea?.value;

                const formData = new FormData();
                formData.append('tramite_id', tramiteId);
                formData.append('paso_id', pasoId);
                formData.append('es_valido', es_valido);
                formData.append('observaciones', observaciones);

                fetch('/validaciones/guardar', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Respuesta al guardar paso', pasoId, data);
                    if (data.prevencion && typeof data.prevencion.es_valido !== 'undefined') {
                        actualizarColorFondo(data.prevencion.es_valido.toString());
                    } else {
                        actualizarColorFondo(null);
                    }
                })
                .catch(error => console.error('Error al guardar:', error));
            });
        }
    }

    // Llama esta función por cada paso dinámico que cargues (desde Livewire, o iterando en el DOM)
    iniciarValidacion({{ $pasoId }}, {{ $tramiteId }});
});
</script>
@endpush
