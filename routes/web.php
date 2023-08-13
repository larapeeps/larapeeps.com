<?php

use App\Models\Group;
use App\Models\Person;
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
    $featuredPeeps = Person::findMany($groups->flatMap(fn ($group) => array_slice($group->members, 0, 4))->unique());
    $relation = $groups->first()->people();
    
    $relation->match($groups->all(), $featuredPeeps, 'people');

    return view('homepage', [
        'groups' => $groups,
    ]);
});

Route::get('/{group}', function (Group $group) {
    return view('group', [
        'group' => $group,
    ]);  
})->name('group');
