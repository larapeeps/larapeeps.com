<?php

use App\Models\Group;
use App\Models\Person;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Arispati\EmojiRemover\EmojiRemover;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('app:add-group', function () {
    Group::create([
        'name' => $name = text(label: 'Name', required: true),
        'slug' => Str::slug($name),
        'members' => [],
    ]);
});

Artisan::command('app:add-person {handle}', function ($handle) {
    $data = Http::withToken(config('services.twitter.token'))
        ->baseUrl('https://api.twitter.com/1.1')
        ->get("/users/show.json?screen_name={$handle}")
        ->json();

    $person = Person::create([
        'name' => $name = text(
            label: 'Full name',
            default: trim(EmojiRemover::filter($data['name'])),
        ),
        'bio' => text(
            label: 'Bio',
            default: $data['description'],
        ),
        'slug' => Str::slug($name),
        'avatar_url' => Str::replace('_normal', '_200x200', $data['profile_image_url_https']),
        'x_handle' => $handle,
        'github_handle' => null,
    ]);

    if ($groups = multiselect('Groups', Group::pluck('name', 'slug'))) {
        Group::findMany($groups)->each(function (Group $group) use ($person) {
            if (array_search($person->slug, $group->members) === false) {
                $group->update(['members' => array_merge($group->members, [$person->slug])]);
            }
        });
    }
});
