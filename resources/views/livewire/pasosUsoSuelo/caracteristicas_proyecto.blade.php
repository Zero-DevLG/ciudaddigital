<div>
{{-- Sección 3: Características del Proyecto --}}
    <section class="border rounded-md p-6 bg-gray-50">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Características del Proyecto</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
                <dt class="font-medium">Descripción general</dt>
                <dd class="mt-1 text-gray-900">{{ $tramite_proyecto->descripcion_general }}</dd>
            </div>
            <div>
                <dt class="font-medium">Impacto estimado</dt>
                <dd class="mt-1 text-gray-900">{{ $impacto_estimado->impacto }}</dd>
            </div>
            <div>
                <dt class="font-medium">Tipo de construcción</dt>
                <dd class="mt-1 text-gray-900">{{ $tipo_construccion->tipo_construccion }}</dd>
            </div>
            <div>
                <dt class="font-medium">Niveles proyectados</dt>
                <dd class="mt-1 text-gray-900">{{ $tramite_proyecto->niveles }}</dd>
            </div>
            <div class="md:col-span-2">
                <dt class="font-medium">Infraestructura seleccionada</dt>
                <dd class="mt-1 text-gray-900">

                     <ul class="mt-2 list-disc list-inside text-gray-700">
                        @foreach ($car_proyecto->infraestructuras as $infra)
                            <li>{{ $infra->infraestructura }}</li>
                        @endforeach
                    </ul>

                </dd>
            </div>
            <div class="md:col-span-2">
                <dt class="font-medium">Plano</dt>
                <dd class="mt-1 text-gray-900">

                    @if ($plano_documento)
                        <a href="{{ asset('storage/' . $plano_documento->url) }}" class="text-indigo-600 underline" target="_blank">Ver plano</a>
                    @else
                        <span class="text-gray-500">No se ha adjuntado un plano</span>
                    @endif

                </dd>
            </div>
            <div class="md:col-span-2">
                <dt class="font-medium">Estudio de impacto ambiental</dt>
                <dd class="mt-1 text-gray-900">

                    @if ($estudio_impacto_documento)
                        <a href="{{ asset('storage/' . $estudio_impacto_documento->url) }}" class="text-indigo-600 underline" target="_blank">Ver estudio de impacto</a>
                    @else
                        <span class="text-gray-500">No se ha adjuntado un estudio de impacto ambiental</span>
                    @endif

                </dd>
        </dl>
    </section>
</div>
