<div class="w-full flex items-center justify-center py-4 overflow-x-auto">
    <div class="flex items-center relative space-x-4">

        @foreach ($pasos as $index => $paso)
            <!-- Paso individual -->
            <div class="flex flex-col items-center relative">
                <div
                    class="@if ($paso->id === $pasoActual) bg-[#BC955C] @else bg-[#BC955C]/80 @endif
                            w-10 h-10 flex items-center justify-center
                            rounded-full text-white text-sm font-semibold shadow-md z-10">
                    {{ $paso->n_paso }}
                </div>
                <span class="mt-1 text-xs text-gray-800 text-center whitespace-nowrap w-24">
                    {{ Str::headline(str_replace('_', ' ', $paso->nombre_paso)) }}
                </span>
            </div>

            @if (!$loop->last)
                <!-- Línea conectando pasos -->
                <div class="w-6 h-0.5 bg-[#BC955C]"></div>
                <!-- Flecha visual opcional -->
                <svg class="w-3 h-3 text-[#BC955C]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 4l6 6-6 6V4z" clip-rule="evenodd" />
                </svg>
            @endif
        @endforeach

    </div>
</div>
