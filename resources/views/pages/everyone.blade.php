@php

    use function Laravel\Folio\{name};

    name('everyone');

@endphp

<x-layout>
    <div class="max-w-4xl mx-auto px-8">
        <x-header class="flex-col">
            <a class="inline-block mb-4 text-gray-400 hover:underline hover:text-gray-900" href="{{ url('/') }}">Back</a>
            <h1 class="text-6xl font-extrabold">Everyone</h1>
            <p class="mt-4 text-lg">In alphabetical order</p>
        </x-header>

        <livewire:peoplelist />
    </div>
</x-layout>
