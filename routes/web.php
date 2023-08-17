<?php

declare(strict_types=1);

use App\Models\Group;
use App\Models\Person;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $groups = Group::query()->inRandomOrder()->limit(3)->get()->keyBy('slug');

    // We want to display 4 random avatars for each group
    $groups
        ->map(fn ($group) => collect($group->members)->shuffle()->take(4))
        ->pipe(function ($groups) {
            // Replace slugs with models
            $slugs = $groups->flatten()->unique();
            $models = Person::query()->findMany($slugs);

            return $groups->map(fn ($peeps) => $models->find($peeps)->shuffle()->values());
        })
        ->each(function ($people, $slug) use ($groups): void {
            // Set the people relation on the group
            $groups->get($slug)->setRelation('people', $people);
        });

    return view('homepage', ['groups' => $groups]);
});

Route::get('/everyone', fn () => view('everyone', ['people' => Person::orderBy('name')->get()]));

Route::get('/{group}', function (Group $group) {
    return view('group', [
        'group' => $group->setRelation('people', $group->people->shuffle()),
    ]);
})->name('group');
