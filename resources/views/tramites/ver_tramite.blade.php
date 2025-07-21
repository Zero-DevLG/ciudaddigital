<x-app-layout>

    <div style="background-color: #F0F4F8;" class="flex h-[calc(100vh-4rem)] overflow-hidden px-4 py-4 gap-6">

        <main class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow overflow-y-auto flex flex-col">

            <div class=" px-6 py-12 bg-[#FAF9F7] text-gray-800">

                {{-- <div class="bg-[#E7EBF0] border-l-4 border-[#E5B56F] p-5 rounded shadow-sm text-sm">
                    <div class="flex items-start gap-3">

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
                </div> --}}

                <br>

                {{-- Folio y estatus --}}
                <div class="bg-[#FDF5EF] border-l-4 border-[#E5B56F] p-6 mb-10 rounded shadow-sm">
                    <p class="text-xl font-bold text-[#9D2449] mb-1">Folio del Trámite: <span class="font-normal text-gray-900">{{ $tramite->folio }}</span></p>
                    <p class="text-sm text-gray-700">Estatus actual: <strong class="text-[#9D2449]">{{ $estatus_tramite->estado }}</strong></p>
                    <p class="text-sm text-gray-500">Fecha de inicio: {{ $tramite->tramite_inicio }}</p>
                    <p class="text-sm text-gray-500">Fecha de término: {{ $tramite->tramite_termino ?? '—' }}</p>

                    <p class="text-sm text-gray-500"><strong>Descargar acuse de solicitud</strong></p>
                      <a href="{{ asset('storage/' . $acuse_solicitud->url) }}" class="text-[#9D2449] hover:underline" target="_blank">Descargar PDF</a>


                </div>

                {{-- DATOS DEL SOLICITANTE --}}
                <section class="mb-10 bg-white rounded-lg border shadow p-6">
                    <h2 class="text-2xl font-semibold text-[#9D2449] mb-6 flex items-center gap-2">Datos del Solicitante</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <p class="font-medium text-[#9D2449]">Nombre completo</p>
                            <p>{{ $persona->nombre }} {{ $persona->apellido_paterno }} {{ $persona->apellido_materno }}</p>
                        </div>

                        <div>
                            <p class="font-medium text-[#9D2449]">CURP</p>
                            <p>
                                @auth
                                    {{ $persona->curp }}
                                @else
                                    <em class="text-gray-500 italic" title="Este dato es privado">Información confidencial 🔒</em>
                                @endauth
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-[#9D2449]">Teléfono</p>
                            <p>
                                @auth
                                    {{ $persona->telefono }}
                                @else
                                    <em class="text-gray-500 italic" title="Este dato es privado">Información confidencial 🔒</em>
                                @endauth
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-[#9D2449]">Correo electrónico</p>
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
                <section class="mb-10 bg-[#FCFAF8] rounded-lg border shadow p-6">
                    <h2 class="text-2xl font-semibold text-[#9D2449] mb-6 flex items-center gap-2"> Información del Predio</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <p class="font-medium text-[#9D2449]">Clave catastral</p>
                            <p>{{ $predio->clave_catastral }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449]">Ubicación</p>
                            <p>{{ $domicilio_predio->calle }}, {{ $domicilio_predio->delegacion_municipio }}, {{ $domicilio_predio->estado }}, C.P. {{ $domicilio_predio->cp }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449]">Superficie</p>
                            <p>{{ $predio->superficie_total }} m²</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449]">Uso actual</p>
                            <p>{{ $uso_suelo_actual->tipo_uso }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449]">Uso solicitado</p>
                            <p>{{ $uso_suelo_solicitado->tipo_uso }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449]">Tipo de propiedad</p>
                            <p>{{ $tipo_propiedad->tipo_propiedad }}</p>
                        </div>
                    </div>
                </section>

                {{-- CARACTERÍSTICAS DEL PROYECTO --}}
                <section class="mb-10 bg-white rounded-lg border shadow p-6">
                    <h2 class="text-2xl font-semibold text-[#9D2449] mb-6 flex items-center gap-2">Características del Proyecto</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div>
                            <p class="font-medium text-[#9D2449]">Descripción general</p>
                            <p>{{ $tramite_proyecto->descripcion_general }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449]">Impacto estimado</p>
                            <p>{{ $impacto_estimado->impacto }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449]">Tipo de construcción</p>
                            <p>{{ $tipo_construccion->tipo_construccion }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-[#9D2449]">Niveles</p>
                            <p>{{ $tramite_proyecto->niveles }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="font-medium text-[#9D2449]">Infraestructura seleccionada</p>
                            <ul class="list-disc list-inside ml-4 mt-1">
                                @foreach ($car_proyecto->infraestructuras as $infra)
                                    <li>{{ $infra->infraestructura }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="md:col-span-2">
                            <p class="font-medium text-[#9D2449]">Plano</p>
                            <p>{{ $plano_documento ? 'Archivo cargado: ' . $plano_documento->nombre_documento : 'No se adjuntó un plano' }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="font-medium text-[#9D2449]">Estudio de impacto ambiental</p>
                            <p>{{ $estudio_impacto_documento ? 'Archivo cargado: ' . $estudio_impacto_documento->nombre_documento : 'No se adjuntó estudio' }}</p>
                        </div>
                    </div>
                </section>

                {{-- DOCUMENTOS ADJUNTOS --}}
                <section class="mb-12 bg-[#FCFAF8] rounded-lg border shadow p-6">
                    <h2 class="text-2xl font-semibold text-[#9D2449] mb-6"> Documentos Adjuntos</h2>
                    <ul class="list-disc list-inside text-sm ml-4">
                        @forelse ($documentos_tramite as $documento)
                            <li>Archivo cargado: {{ $documento->nombre_documento }}</li>
                        @empty
                            <li>No se han adjuntado documentos</li>
                        @endforelse
                    </ul>
                </section>

                {{-- Resoluciones --}}

                @if($resoluciones)

                 <section class="mb-12 bg-white rounded-lg border shadow p-6">

                    <h2 class="text-2xl font-semibold text-[#9D2449] mb-6">Resoluciones</h2>
                    <hr>

                    @if($resolucion_prevencion)
                        <div class="mb-6">
                            <p class="text-sm text-gray-700 mb-2">Tipo de resolución: <strong class="text-[#9D2449]">{{ $datos_prevencion['tipo_resolucion'] }}</strong></p>
                            <p class="text-sm text-gray-700 mb-2">Fecha de emision: {{ $datos_prevencion['fecha_emision'] }}</p>
                            @if(!$resolucion_prevencion->deleted_at)
                            <p class="text-sm text-gray-700"><strong>Su tramite tiene una resolucion de prevención, debera subsanarla  dentro de los 15 dias habiles despues de su emision</strong></p>
                            @else
                             <p class="text-sm text-green-700"><strong>Prevencion subsanada</strong></p>
                            @endif
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-[#9D2449] mb-2">Pasos del trámite</h3>
                            <ul class="list-disc list-inside ml-4">
                                @foreach($datos_prevencion['tramite_pasos'] as $paso)
                                    <li>{{ $paso->paso->nombre_paso }}
                                        @if($paso->es_valido)
                                            <span class="text-green-600"> - Válido</span>
                                        @else
                                            <span class="text-red-600"> - No válido</span>
                                        @endif
                                        @if($paso->observaciones)
                                            <p class="text-sm text-gray-600 mt-1">Observaciones: {{ $paso->observaciones }}</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            <p>Descargar documento de resolución</p>
                            <a href="{{ asset('storage/' . $resolucion_prevencion->documento->url) }}" class="text-[#9D2449] hover:underline" target="_blank">Descargar PDF</a>

                        </div>
                        <hr>
                    @endif
                    @if($resolucion_f)
                     <div class="mb-6">
                            <p class="text-sm text-gray-700 mb-2">Tipo de resolución: <strong class="text-[#9D2449]">{{ $resolucion_f->tipoResolucion->nombre }}</strong></p>
                            <p class="text-sm text-gray-700 mb-2">Fecha de emision: {{ $resolucion_f->fecha_emision }}</p>
                        </div>

                        <div class="mb-6">
                            <p>Descargar documento de resolución</p>
                            <a href="{{ asset('storage/' . $resolucion_f->documento->url) }}" class="text-[#9D2449] hover:underline" target="_blank">Descargar PDF</a>

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
