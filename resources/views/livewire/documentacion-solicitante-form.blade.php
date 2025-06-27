<div>
    <h1 class="text-3xl font-bold text-gray-900 mb-4">Carga de Documentación Requerida</h1>
    <p class="mb-8 text-gray-600">
        Por favor, sube los documentos solicitados para completar tu trámite. Asegúrate de que los archivos sean en formato PDF, JPG o PNG y que el tamaño no exceda los límites establecidos.
        <br>
        Si algún documento no aplica para tu caso, puedes dejarlo vacío.
    </p>

    <!-- No hay formulario con submit, solo inputs con wire:model -->
    <div class="space-y-6">

        <!-- Identificación oficial -->
        <div>
            <label for="identificacion" class="block text-sm font-medium text-gray-700 mb-1">
                Identificación oficial (INE o pasaporte)
            </label>
            <input type="file" id="identificacion" wire:model="identificacion"
                class="block w-full text-gray-700 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            @error('identificacion')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Comprobante de domicilio -->
        <div>
            <label for="comprobante_domicilio" class="block text-sm font-medium text-gray-700 mb-1">
                Comprobante de domicilio reciente (no mayor a 3 meses)
            </label>
            <input type="file" id="comprobante_domicilio" wire:model="comprobante_domicilio"
                class="block w-full text-gray-700 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            @error('comprobante_domicilio')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Escritura pública -->
        <div>
            <label for="escritura" class="block text-sm font-medium text-gray-700 mb-1">
                Escritura pública de la propiedad (si es propietario)
            </label>
            <input type="file" id="escritura" wire:model="escritura"
                class="block w-full text-gray-700 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            @error('escritura')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Poder notarial -->
        <div>
            <label for="poder_notarial" class="block text-sm font-medium text-gray-700 mb-1">
                Poder notarial (si es representante legal)
            </label>
            <input type="file" id="poder_notarial" wire:model="poder_notarial"
                class="block w-full text-gray-700 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            @error('poder_notarial')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Comprobante pago impuestos -->
        <div>
            <label for="comprobante_impuestos" class="block text-sm font-medium text-gray-700 mb-1">
                Comprobante de pago de impuestos o predial
            </label>
            <input type="file" id="comprobante_impuestos" wire:model="comprobante_impuestos"
                class="block w-full text-gray-700 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            @error('comprobante_impuestos')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Documentos adicionales -->
        <div>
            <label for="documentos_adicionales" class="block text-sm font-medium text-gray-700 mb-1">
                Documentos adicionales (opcional)
            </label>
            <input type="file" id="documentos_adicionales" wire:model="documentos_adicionales"
                class="block w-full text-gray-700 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            @error('documentos_adicionales')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

    </div>
</div>
