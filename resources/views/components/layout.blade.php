<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <x-seo::meta />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,700,800&display=swap" rel="stylesheet"/>

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-[Figtree] text-gray-900 bg-white">
        <div class="py-8 md:py-16">
            {{ $slot }}

            <footer class="mt-8 px-6 text-center text-sm text-gray-400 md:mt-16">
                The code for this project is available on <a class="underline" href="https://github.com/larapeeps/larapeeps.com">GitHub</a>.
            </footer>
        </div>
    </body>
</html>
