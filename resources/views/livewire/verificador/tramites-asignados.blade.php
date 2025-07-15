<div class="p-6 bg-white rounded-lg shadow-md">

    {{-- Título principal --}}
    <div class="mb-6 border-b border-gray-200 pb-4">
        <h1 class="text-2xl font-bold text-[#9D2449]">Panel de Verificación de Trámites</h1>
        <p class="text-sm text-gray-600 mt-1">Consulta, valida y da seguimiento a los trámites asignados para revisión.</p>
    </div>

    {{-- Instrucciones para el usuario verificador --}}
    <div class="mb-6 p-4 bg-[#FFF9F4] border-l-4 border-[#E5B56F] rounded shadow-sm">
        <h2 class="text-[#9D2449] font-semibold text-lg mb-1">Instrucciones para verificación</h2>
        <ul class="text-sm text-gray-800 list-disc list-inside space-y-1">
            <li>Revisa que los datos del trámite estén completos y correctamente registrados.</li>
            <li>Haz clic en <span class="font-semibold text-green-700">Abrir</span> para acceder al expediente y validar la información ingresada.</li>
            <li>El estatus actual del trámite se mostrará en la columna <strong>Estado</strong>.</li>
            <li>Si el trámite requiere correcciones, realiza la prevención correspondiente.</li>
        </ul>
    </div>

    {{-- Tabla de trámites --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
                <tr>
                    <th class="px-4 py-2 text-left">Trámite</th>
                    <th class="px-4 py-2 text-left">Folio</th>
                    <th class="px-4 py-2 text-left">Fecha de solicitud</th>
                    <th class="px-4 py-2 text-left">Estado</th>
                    <th class="px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse ($tramites as $tramite)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $tramite->tipo_tramite_nombre }}</td>
                        <td class="px-4 py-2">{{ $tramite->folio ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $tramite->created_at }}</td>
                        <td class="px-4 py-2">{{ $tramite->catalogo_estatus_estado ?? 'Pendiente' }}</td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <a href="{{ route('tramites.validar', $tramite->id) }}" class="text-green-600 hover:underline">Abrir</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500 italic">No hay trámites asignados para verificación.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
