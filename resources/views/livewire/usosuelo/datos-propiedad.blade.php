<div>
    {{ $tramiteId }}
    <div class="">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Información del Predio</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Clave catastral -->
            <div class="col-span-1 md:col-span-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Clave catastral</label>
                <input type="text" wire:model.defer="clave_catastral"
                    class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                @error('clave_catastral')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Dirección del predio -->

            <div class="col-span-1 md:col-span-3">
                <h2 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Dirección del Predio</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <input type="text" wire:model.defer="estado"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                        @error('estado')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Delegación o Municipio -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Delegación / Municipio</label>
                        <input type="text" wire:model.defer="delegacion_municipio"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                        @error('delegacion_municipio')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Código Postal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Código Postal</label>
                        <input type="text" wire:model.defer="cp"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            maxlength="5" />
                        @error('cp')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Calle -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Calle</label>
                        <input type="text" wire:model.defer="calle"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                        @error('calle')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Número exterior -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Número Exterior</label>
                        <input type="text" wire:model.defer="n_exterior"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                        @error('n_exterior')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Número interior -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Número Interior</label>
                        <input type="text" wire:model.defer="n_interior"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                        @error('n_interior')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


            </div>





            <!-- Mapa -->
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Selecciona ubicación en el mapa</label>
                <div id="map" class="w-full h-80 rounded border border-gray-300"></div>
            </div>

            <!-- Latitud y longitud -->
            <div class="space-y-4 col-span-1 md:col-span-1">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitud</label>
                    <input type="text" wire:model="latitud" readonly
                        class="w-full rounded border border-gray-300 bg-gray-100 px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitud</label>
                    <input type="text" wire:model="longitud" readonly
                        class="w-full rounded border border-gray-300 bg-gray-100 px-3 py-2" />
                </div>
            </div>

            <!-- Superficie total -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Superficie total del terreno (m²)</label>
                <input type="number" step="0.01" wire:model.defer="superficie_terreno"
                    class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                @error('superficie_terreno')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Uso actual -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Uso actual del suelo</label>
                <select wire:model.defer="uso_actual"
                    class="mt-1 block w-full rounded border border-gray-300 text-black px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccione...</option>
                    @foreach ($catalogoUsos as $uso)
                        <option value="{{ $uso->id }}">{{ $uso->tipo_uso }}</option>
                    @endforeach
                </select>
                @error('uso_actual')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tipo de propiedad -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de propiedad</label>
                <select wire:model.defer="tipo_propiedad"
                    class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccione...</option>
                    @foreach ($catalogoTipos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->tipo_propiedad }}</option>
                    @endforeach
                </select>
                @error('tipo_propiedad')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Uso propuesto -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Uso propuesto solicitado</label>
                <select wire:model.defer="uso_propuesto"
                    class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccione...</option>
                    @foreach ($catalogoPropuestos as $propuesto)
                        <option value="{{ $propuesto->id }}">{{ $propuesto->tipo_uso }}</option>
                    @endforeach
                </select>
                @error('uso_propuesto')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <hr>
        <!-- Checkbox acceso y zona -->

        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Accesibilidad</h2>

        <div class="grid grid-cols-1 md:grid-cols-2  border-gray-200">
            <div class="flex items-center space-x-3">
                <input type="checkbox" wire:model.defer="acceso_vialidad" class="rounded border-gray-300 h-5 w-5">
                <label class="text-sm text-gray-700 select-none">¿Cuenta con acceso directo a vialidades?</label>
            </div>

            <div class="flex items-center space-x-3">
                <input type="checkbox" wire:model.defer="zona_urbana" class="rounded border-gray-300 h-5 w-5">
                <label class="text-sm text-gray-700 select-none">¿Está en zona urbana?</label>
            </div>
        </div>
    </div>

    @script
        <script>
            console.log('Cargando mapa...');

            let map;
            let marker;

            $wire.on('initMapaLeaflet', () => {
                console.log('Inicializando mapa...');

                const defaultLatLng = [{{ $latitud ?? 19.4326 }}, {{ $longitud ?? -99.1332 }}];

                // Solo inicializa si no existe ya
                if (!map) {
                    map = L.map('map').setView(defaultLatLng, 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    // Marcador inicial
                    if ({{ $latitud && $longitud ? 'true' : 'false' }}) {
                        marker = L.marker(defaultLatLng).addTo(map);
                    }

                    map.on('click', function(e) {
                        const {
                            lat,
                            lng
                        } = e.latlng;

                        if (marker) {
                            marker.setLatLng(e.latlng);
                        } else {
                            marker = L.marker(e.latlng).addTo(map);
                        }

                        console.log(lat, lng);

                        document.querySelector('input[wire\\:model="latitud"]').value = lat;
                        document.querySelector('input[wire\\:model="longitud"]').value = lng;

                        Livewire.dispatch('setCoordinates', {
                            lat,
                            lng
                        });
                    });
                }
            });
        </script>
    @endscript
