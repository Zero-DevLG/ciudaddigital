@php

    $config = app(App\Services\ConfigService::class);

    $config->clearCache();

@endphp


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <style>
        :root {


            --color-sidebar: {{ $config->get('color_sidebar', '#111827') }};
            --color-navbar: {{ $config->get('color_navbar', '#ffffff') }};
            --color-body: {{ $config->get('color_body', '#111827') }};
            --color-show-info: {{ $config->get('color_show_info', '#111827') }};
            --color-info: {{ $config->get('color_info', '#111827') }};
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/login.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <img class="img-login"
                src="{{ app(App\Services\ConfigService::class)->get('logo', asset('img/default.png')) }}"
                alt="Logo">
        </div>

        <div class="w-full     bg-custom-gray overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
