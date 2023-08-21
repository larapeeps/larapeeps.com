<?php
    use function Laravel\Folio\{name};

    name('group');
?>

@php
    $group = $group->setRelation('people', $group->people->shuffle());
@endphp

<x-layout>
    <div class="px-6">
        <header class="md:text-center">
            <a href="{{ route('home') }}" class="mb-6 inline-flex items-center md:mb-10">               
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="mb-0.5 mr-2 w-3 h-3 text-gray-400 md:hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                <img class="md:h-6" src="{{ asset('img/logotype.svg') }}" alt="Larapeeps logotype">
            </a>
            <h1 class="text-4xl font-extrabold md:text-5xl">{{ $group->name }}</h1>
            <p class="mt-4 text-lg md:text-xl">{{ $group->description }}</p>
        </header>
    </div>
    
    <div class="mt-4 max-w-3xl mx-auto md:mt-12">
        <x-peoplelist :people="$group->people" />
    </div>
</x-layout>
