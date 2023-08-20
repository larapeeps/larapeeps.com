<?php
    use function Laravel\Folio\{name};

    name('peeps:show');
?>

<x-layout>
    <div class="max-w-4xl mx-auto px-8">
        <header class="text-center">
            <a class="inline-block mb-4 text-gray-400 hover:underline hover:text-gray-900" href="{{ route('home') }}">Back</a>
            <h1 class="text-6xl font-extrabold">{{ $person->name }}</h1>
            <p class="mt-4 text-lg">{{ $person->slug }}</p>
        </header>

        Peep
    </div>
</x-layout>
<div>
    //
</div>
