<div class="bg-white p-6 rounded-lg shadow-md">
    {{ $tramite_id }}
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Datos personales del solicitante</h2>
    <p class="text-sm text-gray-500 mb-6">Por favor, completa todos los campos con la información del solicitante. Los campos marcados con * son obligatorios.</p>


    @if($tramite_estatus == 5)
        <div class="inline-block px-3 py-1 text-sm font-semibold text-red-700 bg-red-100 border border-red-300 rounded-lg">
            ⚠ Es necesario modificar la información de este paso
        </div>
    @endif




    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Nombre(s) -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Nombre(s) *</label>
            <input type="text" wire:model.defer="nombre"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"  @if(!$modo_edicion) disabled @endif />
            @error('nombre')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Apellido paterno -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Apellido paterno *</label>
            <input type="text" wire:model.defer="apellido_paterno"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"  @if(!$modo_edicion) disabled @endif />
            @error('apellido_paterno')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Apellido materno -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Apellido materno</label>
            <input type="text" wire:model.defer="apellido_materno"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"  @if(!$modo_edicion) disabled @endif />
            @error('apellido_materno')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- RFC -->
        <div>
            <label class="block text-sm font-medium text-gray-700">RFC *</label>
            <input type="text" wire:model.defer="rfc"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm uppercase focus:ring-blue-500 focus:border-blue-500"
                maxlength="13"  @if(!$modo_edicion) disabled @endif />
            @error('rfc')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- CURP -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">CURP *</label>
            <input type="text" wire:model.defer="curp"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm uppercase focus:ring-blue-500 focus:border-blue-500"
                maxlength="18"  @if(!$modo_edicion) disabled @endif />
            @error('curp')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Teléfono -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Teléfono *</label>
            <input type="text" wire:model.defer="telefono"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                maxlength="15"  @if(!$modo_edicion) disabled @endif />
            @error('telefono')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Correo electrónico -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Correo electrónico *</label>
            <input type="email" wire:model.defer="correo_electronico"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"  @if(!$modo_edicion) disabled @endif />
            @error('correo_electronico')
                <span class="text-xs text-red-600">{{ $message }}</span>
            @enderror
        </div>

    </div>
</div>
