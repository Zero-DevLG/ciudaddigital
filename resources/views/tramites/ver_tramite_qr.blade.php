<x-app-layout>
  <div class="min-h-screen bg-gray-50 flex flex-col justify-center px-4 py-8">
    <main class="bg-white max-w-md w-full mx-auto rounded-lg shadow-md p-6 flex flex-col gap-6">

      {{-- Encabezado --}}
      <header class="text-center">
        <h1 class="text-2xl font-bold text-[#9D2449] mb-2">Validación Oficial del Trámite</h1>
        <p class="text-gray-600 text-sm">
          Folio: <strong class="text-gray-800">{{ $tramite->folio }}</strong>
        </p>
        <p class="text-gray-600 text-sm mt-1">
          Estado: <span class="font-semibold text-[#9D2449]">{{ $estatus_tramite->estado }}</span>
        </p>
      </header>

      {{-- Nota informativa --}}
      <section class="bg-[#FAF9F7] border-l-4 border-[#E5B56F] p-4 rounded shadow-sm text-gray-700 text-sm">
        <p>
          Esta vista confirma que el trámite con folio <strong>{{ $tramite->folio }}</strong> está registrado oficialmente y es válido.
        </p>
        <p class="mt-2">
          Para detalles adicionales, consulta tu perfil con acceso autorizado.
        </p>
      </section>

      {{-- Datos del Solicitante --}}
      <section class="bg-white border rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold text-[#9D2449] mb-4">Datos del Solicitante</h2>
        <dl class="grid grid-cols-1 gap-3 text-sm text-gray-700">
          <div>
            <dt class="font-medium">Nombre completo</dt>
            <dd>{{ $persona->nombre }} {{ $persona->apellido_paterno }} {{ $persona->apellido_materno }}</dd>
          </div>
          <div>
            <dt class="font-medium">CURP</dt>
            <dd>
              @auth
                {{ $persona->curp }}
              @else
                <em class="italic text-gray-400 flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.104-.896-2-2-2s-2 .896-2 2v2h4v-2z" /><path stroke-linecap="round" stroke-linejoin="round" d="M5 11h14a1 1 0 011 1v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7a1 1 0 011-1z" /></svg>
                  Información confidencial 🔒
                </em>
              @endauth
            </dd>
          </div>
          <div>
            <dt class="font-medium">Teléfono</dt>
            <dd>
              @auth
                {{ $persona->telefono }}
              @else
                <em class="italic text-gray-400 flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.104-.896-2-2-2s-2 .896-2 2v2h4v-2z" /><path stroke-linecap="round" stroke-linejoin="round" d="M5 11h14a1 1 0 011 1v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7a1 1 0 011-1z" /></svg>
                  Información confidencial 🔒
                </em>
              @endauth
            </dd>
          </div>
          <div>
            <dt class="font-medium">Correo electrónico</dt>
            <dd>
              @auth
                {{ $persona->correo_electronico }}
              @else
                <em class="italic text-gray-400 flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.104-.896-2-2-2s-2 .896-2 2v2h4v-2z" /><path stroke-linecap="round" stroke-linejoin="round" d="M5 11h14a1 1 0 011 1v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7a1 1 0 011-1z" /></svg>
                  Información confidencial 🔒
                </em>
              @endauth
            </dd>
          </div>
        </dl>
      </section>

      {{-- Resoluciones --}}
      <section class="bg-white border rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold text-[#9D2449] mb-4">Resoluciones</h2>

        @if($resolucion_prevencion)

            <div class="mb-4 text-gray-800 text-sm space-y-2">
              <p><strong>Tipo:</strong> <span class="text-[#9D2449]">{{ $datos_prevencion['tipo_resolucion'] }}</span></p>
              <p><strong>Fecha de emisión:</strong> {{ \Carbon\Carbon::parse($datos_prevencion['fecha_emision'])->format('d/m/Y') }}</p>
              @if(!$resolucion_prevencion->deleted_at)
                <p class="font-semibold text-red-600">Esta resolución de prevención debe ser subsanada en 15 días hábiles.</p>
              @else
                <p class="font-semibold text-green-600">Prevención subsanada correctamente.</p>
              @endif

              <h3 class="font-semibold mt-4 mb-2 text-[#9D2449]">Pasos del trámite</h3>
              <ul class="list-disc list-inside text-sm">
                @foreach($datos_prevencion['tramite_pasos'] as $paso)
                  <li>
                    {{ ucwords(str_replace('_', ' ', $paso->paso->nombre_paso)) }}
                    @if($paso->es_valido)
                      <span class="text-green-600"> - Válido</span>
                    @else
                      <span class="text-red-600"> - No válido</span>
                    @endif
                    @if($paso->observaciones)
                      <p class="text-gray-600 mt-1 text-xs">Observaciones: {{ $paso->observaciones }}</p>
                    @endif
                  </li>
                @endforeach
              </ul>
             @auth
              <a href="{{ asset('storage/' . $resolucion_prevencion->documento->url) }}" target="_blank" rel="noopener noreferrer"
                class="mt-4 block bg-[#9D2449] text-white text-center rounded py-2 text-sm hover:bg-[#7b1f39] transition">
                Descargar Resolución (PDF)
              </a>
            </div>
          @else
            <div class="flex items-center gap-2 text-gray-600 italic justify-center text-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              </svg>
              <p><strong>Para descargar el formato de resolución es necesario iniciar sesión en la plataforma.</strong></p>
            </div>
          @endauth
        @endif

        @if($resolucion_f)

            <div class="mb-4 text-gray-800 text-sm space-y-2">
              <p><strong>Tipo:</strong> <span class="text-[#9D2449]">{{ $resolucion_f->tipoResolucion->nombre }}</span></p>
              <p><strong>Fecha de emisión:</strong> {{ \Carbon\Carbon::parse($resolucion_f->fecha_emision)->format('d/m/Y') }}</p>
            @auth
              <a href="{{ asset('storage/' . $resolucion_f->documento->url) }}" target="_blank" rel="noopener noreferrer"
                class="block bg-[#9D2449] text-white text-center rounded py-2 text-sm hover:bg-[#7b1f39] transition">
                Descargar Resolución (PDF)
              </a>
            </div>
          @else
            <div class="flex items-center gap-2 text-gray-600 italic justify-center text-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              </svg>
              <p><strong>Para descargar el formato de resolución es necesario iniciar sesión en la plataforma.</strong></p>
            </div>
          @endauth
        @endif
      </section>

      {{-- Footer / Acción --}}
      <footer class="text-center text-gray-500 text-xs mt-6">
        <p>© {{ date('Y') }} Plataforma Institucional. Todos los derechos reservados.</p>
      </footer>
    </main>
  </div>
</x-app-layout>
