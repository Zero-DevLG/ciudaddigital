<div>


    <div class="space-y-6">
        <h2 class="text-lg font-semibold text-gray-800">Ingresar las características del proyecto</h2>

             @if($tramite_estatus == 5)
            @if($modo_edicion)
                <div class="inline-block px-3 py-1 text-sm font-semibold text-red-700 bg-red-100 border border-red-300 rounded-lg">
                    ⚠ Es necesario modificar la información de este paso
                    <p><Strong>Observaciones del verificador: <span class="text-sm font-semibold text-red-700">{{ $observaciones }}</span></Strong></p>
                </div>

                @else
                <div class="inline-block px-3 py-1 text-sm font-semibold text-green-700 bg-green-100 border border-green-300 rounded-lg">
                    ✅ Información del solicitante
                    <p><Strong>Observaciones del verificador: <span class="text-sm font-semibold text-green-700">{{ $observaciones }}</span></Strong></p>
                </div>
            @endif
        @endif

        @if ($showForm == 'si')
            <div class="space-y-4 border-t pt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Descripción general del proyecto</label>
                    <textarea wire:model.defer="descripcion_general" rows="3" class="w-full mt-1 border-gray-300 rounded-md" @if(!$modo_edicion) disabled @endif></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Impacto estimado</label>
                    <select wire:model.defer="impacto_estimado_id" class="w-full border-gray-300 rounded-md" @if(!$modo_edicion) disabled @endif>
                        <option value="">Seleccione...</option>
                        @foreach ($catalogoImpactos as $impacto)
                            <option value="{{ $impacto->id }}">{{ $impacto->impacto }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Plano --}}
<div>
    <label class="block text-sm font-medium text-gray-700">Plano o croquis del terreno</label>

    @if ($planoExistente)
        <p class="text-green-600 text-sm">
            Ya se cargó un archivo: <a href="{{ Storage::url($planoExistente) }}" target="_blank" class="underline">Ver archivo</a>
               <input type="file" wire:model="plano" class="w-full" @if(!$modo_edicion) disabled @endif />
        @error('plano') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </p>
    @else
        <input type="file" wire:model="plano" class="w-full" />
        @error('plano') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
    @endif
</div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo de construcción proyectada</label>
                    <select wire:model.defer="tipo_construccion_id" class="w-full border-gray-300 rounded-md" @if(!$modo_edicion) disabled @endif>
                        <option value="">Seleccione...</option>
                        @foreach ($catalogoConstrucciones as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->tipo_construccion }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Niveles o pisos proyectados</label>
                    <input type="number" wire:model.defer="niveles" min="1"
                        class="w-full border-gray-300 rounded-md" @if(!$modo_edicion) disabled @endif />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Infraestructura básica</label>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach ($catalogoInfraestructura as $infra)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" wire:model.defer="infraestructura_seleccionada"
                                    value="{{ $infra->id }}" class="rounded border-gray-300" @if(!$modo_edicion) disabled @endif>
                                <span class="text-sm">{{ $infra->infraestructura }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

               {{-- Estudio de Impacto Ambiental --}}
<div>
    <label class="block text-sm font-medium text-gray-700">Estudio de impacto ambiental (PDF, opcional)</label>

    @if ($estudioImpactoExistente)
        <p class="text-green-600 text-sm">
            Ya se cargó un archivo: <a href="{{ Storage::url($estudioImpactoExistente) }}" target="_blank" class="underline">Ver archivo</a>
             <input type="file" wire:model="estudio_impacto" class="w-full" @if(!$modo_edicion) disabled @endif />
        @error('estudio_impacto') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </p>
    @else
        <input type="file" wire:model="estudio_impacto" class="w-full" />
        @error('estudio_impacto') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
    @endif
</div>

            </div>
        @endif
    </div>



</div>
