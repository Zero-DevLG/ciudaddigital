<div>
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
</div>
