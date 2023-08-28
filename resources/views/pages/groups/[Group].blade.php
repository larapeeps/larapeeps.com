<?php
    use function Laravel\Folio\{name};

    name('group');
?>

@seo(['title' => $group->name . ' - Larapeeps', 'description' => $group->description])

@php
    use App\Models\Person;

    // Eager load all the people in the group by their slugs
    $people = Person::find($group->members);

    // Shuffle the slugs using a seed that's cached for an hour
    $seed = cache()->remember("seed:{$group->slug}", 3600, fn () => random_int(0, 9999));
    $slugs = $group->members->shuffle($seed);

    // Replace the slugs with the Person models
    $group = $group->setRelation('people', $slugs->map(fn ($slug) => $people->find($slug)));
@endphp

<x-layout>
    <header>
        <div class="max-w-4xl mx-auto px-6 md:px-12">
            <nav class="flex items-center justify-between mb-6 md:mb-10">
                <a href="{{ route('home') }}" class="inline-flex items-center">
                    <svg class="mb-0.5 mr-2 w-2 h-2 text-gray-400 md:w-3 md:h-3 md:mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    <img class="h-4 md:h-6" src="{{ asset('img/logotype.svg') }}" alt="Larapeeps">
                </a>
                <button
                    type="button"
                    x-data x-on:click="$dispatch('open-search')"
                    class="flex p-2 mb-0.5 items-center justify-center rounded-full transition hover:bg-gray-900/5"
                    aria-label="Find someone..."
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>
            </nav>
            <h1 class="text-4xl font-extrabold md:text-5xl">{{ $group->name }}</h1>
            <p class="max-w-xs mt-2 text-lg leading-relaxed md:text-xl md:max-w-none">{{ $group->description }}</p>
        </div>
    </header>
    
    <main class="mt-4 md:mt-8">
        <div class="max-w-4xl mx-auto">
            <x-peoplelist :people="$group->people" />
        </div>
    </main>
</x-layout>
