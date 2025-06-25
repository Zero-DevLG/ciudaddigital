<div>


    {{ $tramiteId }}

    <div class="space-y-6">
        <h2 class="text-lg font-semibold text-gray-800">Ingresar las características del proyecto</h2>

        {{-- <select id="select-caracteristicas" wire:model.defer="showForm"
            class="formulario-selector border-gray-300 rounded-md w-full">
            <option value="">Seleccione...</option>
            <option value="si">Sí</option>
            <option value="no">No</option>
        </select>


        {{ $showForm }} --}}

        @if ($showForm == 'si')
            <div class="space-y-4 border-t pt-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Descripción general del proyecto</label>
                    <textarea wire:model.defer="descripcion_general" rows="3" class="w-full mt-1 border-gray-300 rounded-md"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Impacto estimado</label>
                    <select wire:model.defer="impacto_estimado_id" class="w-full border-gray-300 rounded-md">
                        <option value="">Seleccione...</option>
                        @foreach ($catalogoImpactos as $impacto)
                            <option value="{{ $impacto->id }}">{{ $impacto->impacto }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Subir plano o croquis del terreno</label>
                    <input type="file" wire:model="plano" class="w-full" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tipo de construcción proyectada</label>
                    <select wire:model.defer="tipo_construccion_id" class="w-full border-gray-300 rounded-md">
                        <option value="">Seleccione...</option>
                        @foreach ($catalogoConstrucciones as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->tipo_construccion }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Niveles o pisos proyectados</label>
                    <input type="number" wire:model.defer="niveles" min="1"
                        class="w-full border-gray-300 rounded-md" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Infraestructura básica</label>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach ($catalogoInfraestructura as $infra)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" wire:model.defer="infraestructura_seleccionada"
                                    value="{{ $infra->id }}" class="rounded border-gray-300">
                                <span class="text-sm">{{ $infra->infraestructura }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Estudio de impacto ambiental (PDF,
                        opcional)</label>
                    <input type="file" wire:model="estudio_impacto" class="w-full" />
                </div>

            </div>
        @endif
    </div>



</div>
