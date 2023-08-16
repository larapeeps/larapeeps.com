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

Artisan::command('add:group', function () {
    Group::create([
        'name' => $name = text(label: 'Name', required: true),
        'slug' => Str::slug($name),
        'members' => [],
    ]);
});

Artisan::command('add:person', function () {
    if (config('services.twitter.token') === null) {
        $this->warn('Twitter API token not set. You can still add a person manually.');
    } else {
        $handle = text('Twitter handle', required: true);

        $data = Http::withToken(config('services.twitter.token'))
            ->baseUrl('https://api.twitter.com/1.1')
            ->get("/users/show.json?screen_name={$handle}")
            ->json();

        $name = trim(EmojiRemover::filter($data['name']));
        $avatar = Str::replace('_normal', '_200x200', $data['profile_image_url_https']);
        $bio = str(EmojiRemover::filter($data['description']))->limit(80);
    }

    $person = Person::create([
        'name' => text('Full name', default: $name ?? '', required: true),
        'slug' => Str::slug($name),
        'bio' => text('Bio', default: $bio ?? ''),
        'x_handle' => $handle ?? null,
        'x_avatar_url' => $avatar ?? null,
        'github_handle' => text('GitHub handle'),
        'website_url' => text('Personal website URL'),
    ]);

    if ($groups = multiselect('Groups', Group::pluck('name', 'slug'))) {
        Group::findMany($groups)->each->addMember($person)->each->save();
    }
});
