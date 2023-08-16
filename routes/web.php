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
    $groups = Group::all();

    $featuredPeepsInGroups = $groups
        ->keyBy('slug')
        ->map(fn ($group) => collect($group->members)->shuffle()->take(4))
        ->pipe(function ($groups) {
            $slugs = $groups->flatten()->unique();
            $models = Person::query()->findMany($slugs);

            return $groups->map(fn ($peeps) => $models->find($peeps)->shuffle()->values());
        });

    $groups->each(function (Group $group) use ($featuredPeepsInGroups) {
        $group->setRelation('people', $featuredPeepsInGroups->get($group->slug));
    });
    
    return view('homepage', ['groups' => $groups]);
});

Route::get('/everyone', function () {
    return view('everyone', ['people' => Person::orderBy('name')->get()]); 
});

Route::get('/{group}', function (Group $group) {
    $group->load('people');

    $group->setRelation('people', $group->people->shuffle());

    return view('group', ['group' => $group]);
})->name('group');
