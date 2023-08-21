<?php
    use function Laravel\Folio\{name};

    name('home');
?>

@php
    use App\Models\Group;
    use App\Models\Person;

    $groups = Group::query()->get();

    $groups->each(function (Group $group) {
        $featuredPeople = collect($group->members)->shuffle()->take(6);

        $group->setRelation('people', Person::find($featuredPeople)->shuffle());
    });

    $groups = $groups->sortByDesc(fn ($group) => count($group->members));
@endphp

<x-layout>
    <div class="max-w-4xl mx-auto px-6 md:px-8 md:text-center">
        <img class="mb-10 inline-block md:h-6" src="{{ asset('img/logotype.svg') }}" alt="Larapeeps logotype">
        <h1 class="-ml-0.5 text-[9vw] leading-tight font-extrabold md:text-6xl md:ml-0">
            Discover <span class="text-red-500">amazing</span> people in the Laravel community
        </h1>
    </div>
    
    <div class="mt-4 max-w-4xl mx-auto md:mt-12">
        <x-grouplist :$groups />
    </div>
</x-layout>
