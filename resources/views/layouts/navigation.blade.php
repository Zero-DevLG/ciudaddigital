@php
    $config = app(App\Services\ConfigService::class);
    $config->clearCache();
@endphp

<nav x-data="{ open: false }" class="bg-[#9D2449] border-b border-[#9D2449] text-white">
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20"> {{-- Aumentamos altura para más espacio al logo --}}
            <div class="flex items-center">

                <div class="shrink-0 flex items-center me-6">
                    <a href="{{ auth()->check() && auth()->user()->usertype === 'admin' ? route('dashboard_admin') : route('dashboard') }}"
                       style="text-decoration: none; color: white; font-weight: bold; font-size: 1.5rem;">
                        {{-- <img src="{{ asset(app(App\Services\ConfigService::class)->get('logo', 'img/default.png')) }}"
                            alt="Logo"
                            class="h-20 w-auto max-h-[80px] object-contain"> --}}
                        <h3 style="color: white">Mi Ciudad Digital</h3>
                    </a>
                </div>

            </div>

            <!-- Settings Dropdown -->
            @if(auth()->check())
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-[#9D2449] dark:text-[#9D2449] bg-white dark:bg-gray-800 hover:text-[#9D2449] dark:hover:text-[#9D2449] focus:outline-none transition ease-in-out duration-150">
                                <div>{{ auth()->user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content" >
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Perfil') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Cerrar sesión') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                {{-- Opcional: Mostrar links para login o registro si no está autenticado --}}
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <a href="{{ route('login') }}" class="text-white px-4 py-2 hover:underline">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="text-white px-4 py-2 hover:underline">Registrarse</a>
                </div>
            @endif

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        @if(auth()->check())
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Perfil') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Cerrar sesión') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            {{-- Opcional: links para login o registro en móvil --}}
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 px-4">
                <a href="{{ route('login') }}" class="block text-gray-800 dark:text-gray-200 py-2">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="block text-gray-800 dark:text-gray-200 py-2">Registrarse</a>
            </div>
        @endif
    </div>
</nav>
