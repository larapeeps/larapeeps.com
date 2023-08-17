@php

    use function Laravel\Folio\{name};

    name('home');

@endphp

<x-layout>
    <div class="max-w-4xl mx-auto px-8">
        <x-header>
            <h1 class="text-center text-6xl font-extrabold">
                Discover <span class="text-red-500">amazing</span> people in the Laravel community
            </h1>
        </x-header>

        <livewire:grouplist />
    </div>
</x-layout>
