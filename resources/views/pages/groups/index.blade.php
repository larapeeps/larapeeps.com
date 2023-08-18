<?php
    use function Laravel\Folio\{name};

    name('groups.index');
?>
@php
    use App\Models\Group;
    use App\Models\Person;

    $groups = Group::query()->paginate();

    $groups->each(function (Group $group) {
        $group->setRelation('people', Person::find(collect($group->members)->shuffle()->take(4)));
    });
@endphp

<x-layout>
    <div class="max-w-4xl mx-auto px-8">
        <header class="text-center">
            <a class="inline-block mb-4 text-gray-400 hover:underline hover:text-gray-900" href="{{ route('home') }}">Back</a>
            <h1 class="text-6xl font-extrabold">All groups</h1>
            <p class="mt-4 text-lg">We have organized the Laravel community into groups. Find the group that interests you and discover amazing people.</p>
        </header>

        <x-grouplist :$groups />

        <div class="text-center mt-8">
            <a class="inline-block px-8 py-4 text-lg font-bold text-white bg-red-500 hover:bg-red-600" href="{{ route('groups.index') }}">View all groups</a>
        </div>
    </div>
</x-layout>
