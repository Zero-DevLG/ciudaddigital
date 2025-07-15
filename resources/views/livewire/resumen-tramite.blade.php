<div>
    {{ $tramiteId }}

    <div    >

    <div class="text-center border-b pb-4">
        <h1 class="text-3xl font-bold text-[#9D2449]">Resumen del Trámite</h1>
        <p class="text-gray-600 mt-2 text-sm">Consulta y verifica todos los datos ingresados antes de continuar con el envío.</p>
    </div>

    {{-- Sección 1: Datos del Solicitante --}}
    <section class="border rounded-md p-6 bg-gray-50">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Datos del Solicitante</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
                <dt class="font-medium">Nombre completo</dt>
                <dd class="mt-1 text-gray-900">{{ $persona->nombre }} {{ $persona->apellido_paterno }} {{  $persona->apellido_materno  }}  </dd>
            </div>
            <div>
                <dt class="font-medium">CURP</dt>
                <dd class="mt-1 text-gray-900">{{ $persona->curp }}</dd>
            </div>
            <div>
                <dt class="font-medium">Teléfono</dt>
                <dd class="mt-1 text-gray-900">{{ $persona->telefono }}</dd>
            </div>
            <div>
                <dt class="font-medium">Correo electrónico</dt>
                <dd class="mt-1 text-gray-900">{{ $persona->correo_electronico }}</dd>
            </div>
        </dl>
    </section>

    {{-- Sección 2: Información del Predio --}}
    <section class="border rounded-md p-6 bg-white">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Información del Predio</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
                <dt class="font-medium">Clave catastral</dt>
                <dd class="mt-1 text-gray-900">{{ $predio->clave_catastral }}</dd>
            </div>
            <div>
                <dt class="font-medium">Ubicación</dt>
                <dd class="mt-1 text-gray-900">{{ $domicilio_predio->calle }}, {{ $domicilio_predio->delegacion_municipio }}, {{ $domicilio_predio->estado }}, {{ $domicilio_predio->cp }}</dd>
            </div>
            <div>
                <dt class="font-medium">Superficie del terreno</dt>
                <dd class="mt-1 text-gray-900">{{ $predio->superficie_total }} m²</dd>
            </div>
            <div>
                <dt class="font-medium">Uso actual del suelo</dt>
                <dd class="mt-1 text-gray-900">{{  $uso_suelo_actual->tipo_uso }}</dd>
            </div>
            <div>
                <dt class="font-medium">Uso solicitado</dt>
                <dd class="mt-1 text-gray-900"><strong>{{ $uso_suelo_solicitado->tipo_uso }}</strong></dd>
            </div>

            <div>
                <dt class="font-medium">Tipo de propiedad</dt>
                <dd class="mt-1 text-gray-900">{{ $tipo_propiedad->tipo_propiedad }}</dd>
            </div>
        </dl>
    </section>

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

    {{-- Botón final --}}
    <div class="text-right pt-4">
        <a href="{{ route('tramite.generar.pdf', ['id' => $tramiteId]) }}"
        class="bg-[#9D2449] hover:bg-text-[#9D2449] text-white font-semibold px-6 py-2 rounded-lg shadow">
            Confirmar y generar solicitud
        </a>
    </div>

</div>



</div>
