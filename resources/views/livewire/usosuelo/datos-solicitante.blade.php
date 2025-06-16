<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <div class="p-6 bg-white rounded shadow-md space-y-6">
        <h2 class="text-xl font-semibold text-gray-800">Datos personales del solicitante</h2>
        <hr>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Nombre(s) -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Nombre(s)</label>
                <input type="text" wire:model.defer="nombre"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                @error('nombre')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Apellido paterno -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Apellido paterno</label>
                <input type="text" wire:model.defer="apellido_paterno"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                @error('apellido_paterno')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Apellido materno -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Apellido materno</label>
                <input type="text" wire:model.defer="apellido_materno"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                @error('apellido_materno')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- RFC -->
            <div>
                <label class="block text-sm font-medium text-gray-700">RFC</label>
                <input type="text" wire:model.defer="rfc"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm uppercase focus:ring-blue-500 focus:border-blue-500"
                    maxlength="13" />
                @error('rfc')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- CURP -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">CURP</label>
                <input type="text" wire:model.defer="curp"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm uppercase focus:ring-blue-500 focus:border-blue-500"
                    maxlength="18" />
                @error('curp')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button wire:click="guardar" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Guardar
            </button>
        </div>
    </div>



</div>
