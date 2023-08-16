<?php

use App\Models\Group;
use App\Models\Person;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\SplFileInfo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
        ->each(function ($people, $slug) use ($groups) {
            // Set the people relation on the group
            $groups->get($slug)->setRelation('people', $people);
        });
    
    return view('homepage', ['groups' => $groups]);
});

Route::get('/everyone', function () {
    return view('everyone', ['people' => Person::orderBy('name')->get()]); 
});

Route::get('/{group}', function (Group $group) {
    return view('group', [
        'group' => $group->setRelation('people', $group->people->shuffle()),
    ]);
})->name('group');
