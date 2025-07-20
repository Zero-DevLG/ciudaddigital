<x-app-layout>

    <div style="background-color: #eae8de;" class="min-h-screen w-full px-4 sm:px-6 lg:px-8 py-6 space-y-8">


        <main class="flex-1 bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md overflow-y-auto flex flex-col space-y-6">


            <div class="px-4 sm:px-6 py-6 sm:py-12 bg-[#FAF9F7] text-gray-800">

               <div class="bg-[#E7EBF0] border-l-4 border-[#E5B56F] p-4 sm:p-6 rounded shadow-sm text-sm max-w-4xl mx-auto">
                <div class="flex flex-col sm:flex-row items-start gap-3">
                    <div class="text-[#3C4653]">
                        <p class="font-semibold text-[#9D2449]">Nota informativa</p>
                        <p class="mt-1">
                        Esta visualización confirma que el trámite con folio <strong>{{ $tramite->folio }}</strong> está registrado oficialmente en la plataforma institucional.
                        La información mostrada es de carácter informativo y refleja el estado vigente del expediente.
                        </p>
                        <p class="mt-2">
                            Para consultar detalles adicionales, como resoluciones u observaciones técnicas, acceda a su perfil y seleccione el trámite correspondiente desde su panel.
                        </p>
                    </div>
                </div>
            </div>


                <br>

                {{-- Folio y estatus --}}
               <div class="bg-[#FDF5EF] border-l-4 border-[#E5B56F] p-4 sm:p-6 mb-10 rounded shadow-sm max-w-4xl mx-auto">
                    <p class="text-lg sm:text-xl font-bold text-[#9D2449] mb-2">
                        Folio del Trámite: <span class="font-normal text-gray-900">{{ $tramite->folio }}</span>
                    </p>
                    <p class="text-sm sm:text-base text-gray-700 mb-1">
                        Estatus actual: <strong class="text-[#9D2449]">{{ $estatus_tramite->estado }}</strong>
                    </p>
                    <p class="text-sm sm:text-base text-gray-500 mb-1">
                        Fecha de inicio: {{ $tramite->tramite_inicio }}
                    </p>
                    <p class="text-sm sm:text-base text-gray-500 mb-4">
                        Fecha de término: {{ $tramite->tramite_termino ?? '—' }}
                    </p>

                    <p class="text-sm sm:text-base text-gray-500 font-semibold mb-1">
                        Descargar acuse de solicitud
                    </p>
                    <a href="{{ asset('storage/' . $acuse_solicitud->url) }}" target="_blank" class="text-[#9D2449] hover:underline text-sm sm:text-base block">
                        Descargar PDF
                    </a>
                </div>

                    <section class="mb-10 bg-white rounded-lg border shadow p-4 sm:p-6 max-w-4xl mx-auto">
                        <h2 class="text-xl sm:text-2xl font-semibold text-[#9D2449] mb-6 flex items-center gap-2">Datos del Solicitante</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm sm:text-base">
                            <div>
                                <p class="font-medium text-[#9D2449] mb-1">Nombre completo</p>
                                <p>{{ $persona->nombre }} {{ $persona->apellido_paterno }} {{ $persona->apellido_materno }}</p>
                            </div>

                            <div>
                                <p class="font-medium text-[#9D2449] mb-1">CURP</p>
                                <p>
                                    @auth
                                        {{ $persona->curp }}
                                    @else
                                        <em class="text-gray-500 italic" title="Este dato es privado">Información confidencial 🔒</em>
                                    @endauth
                                </p>
                            </div>

                            <div>
                                <p class="font-medium text-[#9D2449] mb-1">Teléfono</p>
                                <p>
                                    @auth
                                        {{ $persona->telefono }}
                                    @else
                                        <em class="text-gray-500 italic" title="Este dato es privado">Información confidencial 🔒</em>
                                    @endauth
                                </p>
                            </div>

                            <div>
                                <p class="font-medium text-[#9D2449] mb-1">Correo electrónico</p>
                                <p>
                                    @auth
                                        {{ $persona->correo_electronico }}
                                    @else
                                        <em class="text-gray-500 italic" title="Este dato es privado">Información confidencial 🔒</em>
                                    @endauth
                                </p>
                            </div>
                        </div>
                    </section>

                {{-- PREDIO --}}
                <section class="mb-10 bg-[#FCFAF8] rounded-lg border shadow p-4 sm:p-6 max-w-4xl mx-auto">
                    <h2 class="text-xl sm:text-2xl font-semibold text-[#9D2449] mb-6 flex items-center gap-2">Información del Predio</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm sm:text-base">
                        <div>
                            <p class="font-medium text-[#9D2449] mb-1">Clave catastral</p>
                            <p>{{ $predio->clave_catastral }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449] mb-1">Ubicación</p>
                            <p>{{ $domicilio_predio->calle }}, {{ $domicilio_predio->delegacion_municipio }}, {{ $domicilio_predio->estado }}, C.P. {{ $domicilio_predio->cp }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449] mb-1">Superficie</p>
                            <p>{{ $predio->superficie_total }} m²</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449] mb-1">Uso actual</p>
                            <p>{{ $uso_suelo_actual->tipo_uso }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449] mb-1">Uso solicitado</p>
                            <p>{{ $uso_suelo_solicitado->tipo_uso }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449] mb-1">Tipo de propiedad</p>
                            <p>{{ $tipo_propiedad->tipo_propiedad }}</p>
                        </div>
                    </div>
                </section>


                {{-- CARACTERÍSTICAS DEL PROYECTO --}}
                <section class="mb-10 bg-white rounded-lg border shadow p-4 sm:p-6 max-w-4xl mx-auto">
                    <h2 class="text-xl sm:text-2xl font-semibold text-[#9D2449] mb-6 flex items-center gap-2">Características del Proyecto</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm sm:text-base">
                        <div>
                            <p class="font-medium text-[#9D2449] mb-1">Descripción general</p>
                            <p>{{ $tramite_proyecto->descripcion_general }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449] mb-1">Impacto estimado</p>
                            <p>{{ $impacto_estimado->impacto }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449] mb-1">Tipo de construcción</p>
                            <p>{{ $tipo_construccion->tipo_construccion }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449] mb-1">Niveles</p>
                            <p>{{ $tramite_proyecto->niveles }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="font-medium text-[#9D2449] mb-1">Infraestructura seleccionada</p>
                            <ul class="list-disc list-inside ml-4 mt-1">
                                @foreach ($car_proyecto->infraestructuras as $infra)
                                    <li>{{ $infra->infraestructura }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="md:col-span-2">
                            <p class="font-medium text-[#9D2449] mb-1">Plano</p>
                            <p>{{ $plano_documento ? 'Archivo cargado: ' . $plano_documento->nombre_documento : 'No se adjuntó un plano' }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="font-medium text-[#9D2449] mb-1">Estudio de impacto ambiental</p>
                            <p>{{ $estudio_impacto_documento ? 'Archivo cargado: ' . $estudio_impacto_documento->nombre_documento : 'No se adjuntó estudio' }}</p>
                        </div>
                    </div>
                </section>

                {{-- DOCUMENTOS ADJUNTOS --}}
             <section class="mb-12 bg-[#FCFAF8] rounded-lg border shadow p-4 sm:p-6 max-w-4xl mx-auto">
                <h2 class="text-xl sm:text-2xl font-semibold text-[#9D2449] mb-6">Documentos Adjuntos</h2>
                <ul class="list-disc list-inside text-sm sm:text-base ml-5">
                    @forelse ($documentos_tramite as $documento)
                        <li class="mb-1">Archivo cargado: {{ $documento->nombre_documento }}</li>
                    @empty
                        <li class="italic text-gray-500">No se han adjuntado documentos</li>
                    @endforelse
                </ul>
            </section>

                {{-- Resoluciones --}}

                @if($resoluciones)

                 <section class="mb-12 bg-white rounded-lg border shadow p-4 sm:p-6 max-w-4xl mx-auto">
                    <h2 class="text-xl sm:text-2xl font-semibold text-[#9D2449] mb-6">Resoluciones</h2>
                    <hr class="mb-6">

                    @if($resolucion_prevencion)
                        <div class="mb-6 text-sm sm:text-base text-gray-700">
                            @auth
                                <p class="mb-2">Tipo de resolución: <strong class="text-[#9D2449]">{{ $datos_prevencion['tipo_resolucion'] }}</strong></p>
                                <p class="mb-2">Fecha de emisión: {{ $datos_prevencion['fecha_emision'] }}</p>
                                @if(!$resolucion_prevencion->deleted_at)
                                    <p><strong>Su trámite tiene una resolución de prevención, deberá subsanarla dentro de los 15 días hábiles después de su emisión.</strong></p>
                                @else
                                    <p class="text-green-700 font-semibold">Prevención subsanada</p>
                                @endif

                                <h3 class="text-lg font-semibold text-[#9D2449] mt-6 mb-2">Pasos del trámite</h3>
                                <ul class="list-disc list-inside ml-5 mb-4">
                                    @foreach($datos_prevencion['tramite_pasos'] as $paso)
                                        <li>
                                            {{ $paso->paso->nombre_paso }}
                                            @if($paso->es_valido)
                                                <span class="text-green-600"> - Válido</span>
                                            @else
                                                <span class="text-red-600"> - No válido</span>
                                            @endif
                                            @if($paso->observaciones)
                                                <p class="text-gray-600 mt-1">Observaciones: {{ $paso->observaciones }}</p>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>

                                <p class="font-semibold">Descargar documento de resolución</p>
                                <a href="{{ asset('storage/' . $resolucion_prevencion->documento->url) }}" class="text-[#9D2449] hover:underline" target="_blank" rel="noopener noreferrer">Descargar PDF</a>
                            @else
                                <div class="flex items-center gap-2 text-gray-600 italic">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.104-.896-2-2-2s-2 .896-2 2v2h4v-2z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 11h14a1 1 0 011 1v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7a1 1 0 011-1z" />
                                    </svg>
                                    <span>Inicia sesión para ver los detalles y descargar el documento.</span>
                                </div>
                            @endauth
                        </div>
                        <hr>
                    @endif

                    @if($resolucion_f)
                        <div class="mb-6 text-sm sm:text-base text-gray-700">
                            @auth
                                <p class="mb-2">Tipo de resolución: <strong class="text-[#9D2449]">{{ $resolucion_f->tipoResolucion->nombre }}</strong></p>
                                <p class="mb-2">Fecha de emisión: {{ $resolucion_f->fecha_emision }}</p>
                                <p class="font-semibold">Descargar documento de resolución</p>
                                <a href="{{ asset('storage/' . $resolucion_f->documento->url) }}" class="text-[#9D2449] hover:underline" target="_blank" rel="noopener noreferrer">Descargar PDF</a>
                            @else
                                <div class="flex items-center gap-2 text-gray-600 italic">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.104-.896-2-2-2s-2 .896-2 2v2h4v-2z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 11h14a1 1 0 011 1v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7a1 1 0 011-1z" />
                                    </svg>
                                    <span>Inicia sesión para ver los detalles y descargar el documento.</span>
                                </div>
                            @endauth
                        </div>
                    @endif
                    </section>

                @endif




                {{-- ACCIONES --}}

                @if($tipo_usuario)
                <div class="flex justify-between">
                    @if($tipo_usuario->usertype == 'user-verificador')
                    <a href="{{ route('dashboard_verificador') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded shadow text-sm font-semibold">
                        ← Volver al panel
                    </a>
                    @else
                    <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded shadow text-sm font-semibold">
                        ← Volver al panel
                    </a>
                    @endif
                </div>
                @endif
            </div>

        </main>

    </div>

</x-app-layout>
