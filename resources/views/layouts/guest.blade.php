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

{{--        <link rel="preload" as="style" href="https://hopecancersurgery.com/public/build/assets/app-DEoo0NxM.css" />--}}
{{--        <link rel="modulepreload" href="https://hopecancersurgery.com/public/build/assets/app-T1DpEqax.js" />--}}
{{--        <link rel="stylesheet" href="https://hopecancersurgery.com/public/build/assets/app-DEoo0NxM.css" data-navigate-track="reload" />--}}
{{--        <script type="module" src="https://hopecancersurgery.com/public/build/assets/app-T1DpEqax.js" data-navigate-track="reload"></script>--}}

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
