<?php
    use function Laravel\Folio\{name};

    name('group');
?>

@php
    $group = $group->setRelation('people', $group->people->shuffle());

@endphp

<x-layout>
    <header class="text-center">
        <a class="inline-block mb-4 text-gray-400 hover:underline hover:text-gray-900" href="{{ route('home') }}">Back</a>
        <h1 class="text-6xl font-extrabold">{{ $group->name }}</h1>
        <p class="mt-4 text-lg">{{ $group->description }}</p>
    </header>

    <x-peoplelist :people="$group->people" />
</x-layout>
