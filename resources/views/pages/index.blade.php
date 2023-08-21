<?php
    use function Laravel\Folio\{name};

    name('home');
?>

@php
    use App\Models\Group;
    use App\Models\Person;

    $groups = Group::query()->get();

    $groups->each(function (Group $group) {
        $featuredPeople = collect($group->members)->shuffle()->take(5);

        $group->setRelation('people', Person::find($featuredPeople)->shuffle());
    });

    $groups = $groups->sortByDesc(fn ($group) => count($group->members));
@endphp

<x-layout>
    <header>
        <div class="max-w-4xl mx-auto px-6 md:px-12">
            <img class="block h-4 mb-6 md:h-6" src="{{ asset('img/logotype.svg') }}" alt="Larapeeps logotype">
            <h1 class="-ml-0.5 text-[9vw] leading-tight font-extrabold md:-ml-1 md:text-6xl md:leading-[1.3]">
                Discover <span class="text-red-500">amazing</span> people in&nbsp;the Laravel community
            </h1>
        </div>
    </header>
    
    <main class="mt-4 md:mt-8">
        <div class="max-w-4xl mx-auto">
            <x-grouplist :$groups />
        </div>
    </main>
</x-layout>
