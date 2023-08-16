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

    $name = trim(EmojiRemover::filter($data['name']));
    $name = text('Full name', default: $name);

    $avatar = Str::replace('_normal', '_200x200', $data['profile_image_url_https']);

    $person = Person::create([
        'name' => $name,
        'slug' => Str::slug($name),
        'bio' => text('Bio'),
        'x_handle' => $handle,
        'x_avatar_url' => $avatar,
        'github_handle' => text('GitHub handle'),
        'website_url' => text('Personal website URL'),
    ]);

    if ($groups = multiselect('Groups', Group::pluck('name', 'slug'))) {
        Group::findMany($groups)->each->addMember($person)->each->save();
    }
});
