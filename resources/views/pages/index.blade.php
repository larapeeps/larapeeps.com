@php

    use App\Models\Group;
    use App\Models\Person;
    use function Laravel\Folio\{name};

    name('home');

    $groups = Group::query()->inRandomOrder()->limit(3)->get()->keyBy('slug');

    // Take 4 random people from each group
    $groups
        ->map(fn ($group) => collect($group->members)->shuffle()->take(4))
        ->pipe(function ($groups) {
            // Eager load all featured people
            $slugs = $groups->flatten()->unique();
            $models = Person::query()->findMany($slugs);

            // Replace slugs with Person models inside each group
            return $groups->map(fn ($peeps) => $models->find($peeps)->shuffle()->values());
        })
        ->each(function ($people, $slug) use ($groups): void {
            // Set the the people relation on each group
            $groups->get($slug)->setRelation('people', $people);
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
