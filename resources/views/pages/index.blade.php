<?php
    use function Laravel\Folio\{name};

    name('home');
?>

@php
    use App\Models\Group;
    use App\Models\Person;

    $groups = Group::query()->inRandomOrder()->limit(3)->get();

    $groups->each(function (Group $group) {
        $featuredPeople = collect($group->members)->shuffle()->take(4);

        $group->setRelation('people', Person::find($featuredPeople));
    });
@endphp

<x-layout>
    <div class="max-w-4xl mx-auto px-8">
        <h1 class="text-center text-6xl font-extrabold">
            Discover <span class="text-red-500">amazing</span> people in the Laravel community
        </h1>

        <x-grouplist :$groups />
    </div>
</x-layout>
