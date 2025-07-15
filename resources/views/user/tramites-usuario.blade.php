<x-app-layout>


    <div class="bg-[#eae8de] h-[calc(100vh-4rem)] px-4 py-4">
        <div class="flex h-full gap-4">

            {{-- Sidebar 20% --}}
            <aside class="w-1/5 min-w-[220px] bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md overflow-y-auto">
                <livewire:dashboard.side-menu-user />
            </aside>

            {{-- Contenido principal 80% --}}
           <main class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md overflow-y-auto">
            <div x-data="{ tab: 'borradores' }">

                <h2 class="text-2xl font-bold text-gray-800 mb-6"> Mis Trámites</h2>

                <hr>
                {{-- Tabs --}}
                <div class="flex space-x-6 border-b border-gray-200 mb-6 text-sm font-semibold">
                    <button
                        class="pb-2 border-b-2"
                        :class="tab === 'borradores' ? 'border-[#9D2449] text-[#9D2449]' : 'border-transparent text-gray-500 hover:text-[#9D2449]'"
                        @click="tab = 'borradores'"
                    > Borradores</button>

                    <button
                        class="pb-2 border-b-2"
                        :class="tab === 'curso' ? 'border-[#9D2449] text-[#9D2449]' : 'border-transparent text-gray-500 hover:text-[#9D2449]'"
                        @click="tab = 'curso'"
                    > En curso</button>

                    <button
                        class="pb-2 border-b-2"
                        :class="tab === 'finalizados' ? 'border-[#9D2449] text-[#9D2449]' : 'border-transparent text-gray-500 hover:text-[#9D2449]'"
                        @click="tab = 'finalizados'"
                    > Finalizados</button>
                </div>

                {{-- Contenido tabs --}}
                <div x-show="tab === 'borradores'">
                    <livewire:tramites-usuario :usuario="$usuario" tipo="borradores" />
                </div>

                <div x-show="tab === 'curso'">
                    <livewire:tramites-usuario-curso :usuario="$usuario" tipo="curso" />
                </div>

                <div x-show="tab === 'finalizados'">

                </div>

            </div>
        </main>


        </div>
    </div>
</x-app-layout>
