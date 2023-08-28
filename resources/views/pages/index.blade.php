<?php
    use function Laravel\Folio\{name};

    name('home');
?>

@seo([
    'title' => 'People who make Laravel awesome',
    'description' => 'Discover bloggers, speakers, maintainers, core team members, YouTubers, podcasters, and various people who are contributing to the Laravel community.'
])

@php
    use App\Models\Group;
    use App\Models\Person;

    $groups = Group::query()->get();

    $groups->each(function (Group $group) {
        $seed = cache()->remember('seed:' . $group->slug, now()->addHour(), fn () => random_int(0, 9999));
        $featured = $group->members->shuffle($seed)->take(5);
        $people = Person::find($featured);

        $group->setRelation('people', $featured->map(fn ($slug) => $people->find($slug)));
    });

    $groups = $groups->sortByDesc(fn ($group) => $group->members->count());
@endphp

<x-layout>
    <header>
        <div class="max-w-4xl mx-auto px-6 md:px-12">
            <nav class="mb-6 flex items-center justify-between">
                <img class="block h-4 md:h-6" src="{{ asset('img/logotype.svg') }}" alt="Larapeeps">
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
            <h1 class="-ml-0.5 text-[9vw] leading-tight font-extrabold md:-ml-1 md:text-6xl md:leading-[1.3]">
                Discover <span class="text-red-500">amazing</span> people in&nbsp;the Laravel community
            </h1>
            <p class="mt-4">There are currently <strong>{{ Person::count() }} peeps</strong> in total</p>
        </div>
    </header>
    
    <main class="mt-4 md:mt-8">
        <div class="max-w-4xl mx-auto">
            <x-grouplist :$groups />
        </div>
    </main>
</x-layout>
