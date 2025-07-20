
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- En la sección <head> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        id="btn-vista-previa"
        >
        {{ $mostrarVistaPrevia ? 'Ocultar vista previa' : 'Generar resolución' }}
    </button>

    {{-- Vista previa PDF --}}

                {{-- Subida de archivos para e.firma
        <div class="mt-6">
            <label class="block font-semibold mb-2">Archivo .key</label>
            <input type="file" id="archivo_key" class="mb-4">

            <label class="block font-semibold mb-2">Archivo .cer</label>
            <input type="file" id="archivo_cer" class="mb-4">

            <label class="block font-semibold mb-2">Contraseña de la clave privada</label>
            <input type="password" id="password_firma" class="w-full border border-gray-300 rounded-md shadow-sm p-2 mb-4">

            <button id="btn-firmar-pdf" class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-3 rounded-md shadow-md">
                Firmar PDF
            </button>
        </div> --}}



        <div class="mt-8 border rounded-md shadow-inner h-full">

            <div id="content-preview" class="space-y-4 p-6">

                <!-- Botón fuera del iframe, bien posicionado arriba -->
                <div class="flex justify-end">
                    <button
                        class="bg-[#9D2449] hover:bg-[#7B1C39] text-white text-sm font-semibold px-4 py-2 rounded shadow transition duration-200"
                        id="btn-descargar-resolucion">
                        Descargar la resolución para firma
                    </button>
                </div>

                <!-- Contenedor del PDF con bordes y sombra -->
                <div class="rounded-lg border border-gray-200 shadow overflow-hidden" style="height: 700px;">
                    <iframe
                        src="{{ asset($rutaPdf) }}"
                        class="w-full h-full"
                        frameborder="0"
                        loading="lazy"
                        title="Vista previa de la resolución PDF"
                        id="pdf-preview"
                    ></iframe>
                </div>

            </div>





            <div id="no-resolucion" class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md flex items-start space-x-2">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                </svg>
                <p class="text-sm">No hay vista previa disponible. Por favor, genera primero la resolución para visualizarla aquí.</p>
            </div>
        </div>




        <!-- Modal -->
        <!-- Modal fondo -->
      <div id="modal-resolucion" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300 ease-out hidden opacity-0">
    <!-- Contenido del modal -->
        <div id="modal-content" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-4xl relative transform transition-transform duration-300 scale-95">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Finalizar la verificación</h2>

            <p class="text-gray-700 mb-4">1. Descarga la resolución generada en formato PDF.</p>
            <a href="#" id="confirmar-descarga" target="_blank" class="inline-block px-4 py-2 mb-6 bg-[#7B1C39] hover:bg-[#7B1C39] text-white rounded shadow">
                Descargar resolución
            </a>

            <p class="text-gray-700 mb-4">2. Firma el documento de manera autógrafa.</p>

            <p class="text-gray-700 mb-2">3. Sube el archivo PDF firmado:</p>
            <input type="file" id="archivo-firmado" name="archivo_firmado" accept="application/pdf" class="mb-6 w-full border border-gray-300 rounded px-3 py-2">

            <p class="text-sm text-gray-600 mb-4">Asegúrate de que el archivo firmado coincida con la resolución descargada. Solo se acepta formato PDF.</p>

            <p class="text-sm text-[#7B1C39] mb-4"><strong>Verifica que todos los datos esten correctos, antes de finalizar el proceso, una vez finalizado no es posible editar la resolución</strong></p>

            <div class="flex justify-end space-x-3">
                <button id="cancelar-modal" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">Cancelar</button>
                <button id="finalizar-verificacion" class="px-4 py-2 bg-[#7B1C39] hover:bg-[#7B1C39] text-white rounded">
                    Finalizar proceso de verificación
                </button>
            </div>

            <button id="cerrar-modal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl leading-none">&times;</button>
        </div>
    </div>





</div>


@push('scripts')
    <script>
        $(document).ready(function() {
            console.log('Script de resolución cargado JQuery');

            $('#finalizar-verificacion').on('click', function(event) {
                event.preventDefault();
                const archivoFirmado = $('#archivo-firmado')[0].files[0];


                if (!archivoFirmado) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Por favor, sube el archivo PDF firmado.',
                        icon: 'error',
                    });
                    return;
                }

                const formData = new FormData();
                formData.append('archivo_firmado', archivoFirmado);
                formData.append('tramite_id', {{ $tramiteId }});
                formData.append('_token', '{{ csrf_token() }}');

                Swal.fire({
                    title: 'Finalizando...',
                    text: 'Esto puede tardar unos segundos.',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });

                $.ajax({
                    url: '/verificador/finalizar-verificacion',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.close();
                        if (response.success) {
                             Swal.fire({
                                title: '¡Éxito!',
                                text: 'Proceso de verificación finalizado correctamente.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '{{ route("dashboard_verificador") }}';
                            });
                        } else {
                            Swal.fire('Error', response.message || 'No se pudo finalizar el proceso.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.close();
                        Swal.fire('Error', 'Error al comunicarse con el servidor.', 'error');
                    }
                });
            });


            $('#confirmar-descarga').on('click', function(event) {
                event.preventDefault();
                const url = $('#pdf-preview').attr('src');
                if (url) {
                    window.open(url, '_blank');
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'No hay resolución disponible para descargar.',
                        icon: 'error',
                    });
                }
            });


             $('#cerrar-modal, #cancelar-modal').on('click', function() {
                    ocultarModal();
                });


              function mostrarModal() {
                    const $modal = $('#modal-resolucion');
                    const $content = $('#modal-content');

                    $modal.removeClass('hidden');
                    setTimeout(() => {
                        $modal.removeClass('opacity-0');
                        $content.removeClass('scale-95');
                        $content.addClass('scale-100');
                    }, 10); // pequeño delay para que se aplique el efecto
                }

                function ocultarModal() {
                    const $modal = $('#modal-resolucion');
                    const $content = $('#modal-content');

                    $modal.addClass('opacity-0');
                    $content.removeClass('scale-100').addClass('scale-95');

                    setTimeout(() => {
                        $modal.addClass('hidden');
                    }, 300); // espera a que termine la transición
                }



            $('#content-preview').hide();



            //Firmar resolcion

            $('#btn-descargar-resolucion').on('click', function(event) {
                event.preventDefault();
                console.log('Botón de descargar resolución clickeado');

                // Mostrar modal de confirmación
                mostrarModal();
            });




            //Comprobar si ya existe una resolucion temporal
            $.ajax({
                url: '/verificador/obtener-resolucion-temporal',
                type: 'POST',
                data: {
                    tramite_id: {{ $tramiteId }},
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Respuesta de comprobación de resolución temporal:', response);
                    if (response.success) {
                        $('#pdf-preview').attr('src', response.url);
                        $('#content-preview').show();
                        $('#no-resolucion').hide();
                    } else {
                        $('#no-resolucion').show();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al comprobar resolución temporal:', error);
                }
            });






            // $('#btn-firmar-pdf').on('click', function () {

            //     const formData = new FormData();
            //     formData.append('tramite_id', {{ $tramiteId }});
            //     formData.append('_token', '{{ csrf_token() }}');
            //     formData.append('cer', $('#archivo_cer')[0].files[0]);
            //     formData.append('key', $('#archivo_key')[0].files[0]);
            //     formData.append('password', $('#password_firma').val());

            //     Swal.fire({
            //         title: 'Firmando...',
            //         text: 'Esto puede tardar unos segundos.',
            //         allowOutsideClick: false,
            //         didOpen: () => Swal.showLoading()
            //     });

            //     $.ajax({
            //         url: '/verificador/firmar-resolucion',
            //         type: 'POST',
            //         data: formData,
            //         processData: false,
            //         contentType: false,
            //         success: function (response) {
            //             Swal.close();
            //             if (response.success && response.url) {
            //                 $('#pdf-preview').attr('src', response.url);
            //                 Swal.fire('¡Éxito!', 'Documento firmado correctamente.', 'success');
            //             } else {
            //                 Swal.fire('Error', 'No se pudo firmar el documento.', 'error');
            //             }
            //         },
            //         error: function () {
            //             Swal.close();
            //             Swal.fire('Error', 'Error al comunicarse con el servidor.', 'error');
            //         }
            //     });
            // });





            $('#btn-vista-previa').on('click', function(event) {
                event.preventDefault();
                console.log('Botón de vista previa clickeado');


                if ($(this).text().includes('Ocultar')) {
                } else {

                     let iframe = document.querySelector('iframe');
                    let tipo_resolucion = $('#tipo_resolucion').val();
                    let motivo_resolucion = $('#motivo_resolucion').val();

                    if(tipo_resolucion === '' || motivo_resolucion === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'Por favor, completa todos los campos antes de generar la vista previa.',
                            icon: 'error',
                        });
                        return;
                    }

                        if(tipo_resolucion === '4') {
                            $.ajax({
                                url: '/verificador/obtener-resolucion-prevencion',
                                type: 'POST',
                                data: {
                                    tramite_id: {{ $tramiteId }},
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                console.log('Respuesta de obtener resolución de prevención:', response);
                                prevencion = response.resolucion;
                                console.log('Prevención obtenida:', prevencion);
                                if(prevencion){
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Ya existe una resolución de Prevención para este trámite.',
                                        icon: 'error',
                                    });
                                    return;
                                }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'No se pudo obtener datos correctos.',
                                        icon: 'error',
                                    });
                                    return;
                                }
                            });
                        }

                         Swal.fire({
                            title: 'Generando documento de resolución...',
                            text: 'Esto puede tardar unos segundos.',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading()
                        });

                        $.ajax({
                            url: '/verificador/vista-previa-resolucion',
                            type: 'POST',
                            data: {
                                tipo_resolucion: tipo_resolucion,
                                motivo_resolucion: motivo_resolucion,
                                tramite_id: {{ $tramiteId }},
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    console.log('Vista previa generada correctamente');
                                    console.log(response);
                                    if (response.url) {

                                        Swal.fire({
                                            title: 'Éxito',
                                            text: 'Documento de resolución generado correctamente.',
                                            icon: 'success',
                                        });

                                        $('#pdf-preview').attr('src', response.url);
                                        $('#content-preview').show();
                                        $('#no-resolucion').hide();
                                    }
                                }else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'No se pudo generar la vista previa.',
                                        icon: 'error',
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: error,
                                    icon: 'error',

                                });
                            }
                        });




                    console.log('Actualizando vista previa con tipo:', tipo_resolucion, 'y motivo:', motivo_resolucion);
                }





            });





        });


    </script>

@endpush
