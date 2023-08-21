<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Larapeeps') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,700,800&display=swap" rel="stylesheet"/>

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-[Figtree] text-gray-900 dark:text-gray-50 bg-white dark:bg-gray-900">
        <main class="py-8 md:py-16">
            {{ $slot }}
        </main>
    </body>
</html>
