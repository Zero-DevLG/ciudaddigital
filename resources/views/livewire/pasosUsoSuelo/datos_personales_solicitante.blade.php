<div>
    {{-- Paso: Datos del solicitante --}}
    <h2 class="font-semibold text-[#9D2449] mb-2">Datos Personales del Solicitante</h2>

    <section class="border rounded-md p-6 bg-gray-50 mb-6">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
                <dt class="font-medium">Nombre completo</dt>
                <dd class="mt-1 text-gray-900">{{ $persona->nombre }} {{ $persona->apellido_paterno }} {{ $persona->apellido_materno }}</dd>
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



</div>

