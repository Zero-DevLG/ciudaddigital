<div class="p-6 bg-white rounded-lg shadow-md">



    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
                <tr>
                    <th class="px-4 py-2 text-left">Tramite</th>
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
                           @if($tramite->cat_estatus_id == 5)
                            <a href="{{ route('tramites.uso_suelo', $tramite->id) }}" class="text-green-600 hover:underline">Editar</a>
                            @else
                            <a href="{{ route('tramites.ver', $tramite->id) }}" class="text-indigo-600 hover:underline">Ver</a>
                            @endif


                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500 italic">No hay trámites registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
