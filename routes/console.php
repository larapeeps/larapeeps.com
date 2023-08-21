<?php

declare(strict_types=1);

use App\Models\Group;
use App\Models\Person;
use Arispati\EmojiRemover\EmojiRemover;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\search;
use function Laravel\Prompts\text;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('group:add', function (): void {
    Group::create([
        'name' => $name = text(label: 'Name', required: true),
        'slug' => Str::slug($name),
        'members' => [],
    ]);
});

Artisan::command('person:add', function (): void {
    if (null === config('services.twitter.token')) {
        $this->warn('Twitter API token not set. You can still add a person manually.');
    } else {
        $handle = text('Twitter handle', required: true);

        $data = Http::withToken(config('services.twitter.token'))
            ->baseUrl('https://api.twitter.com/1.1')
            ->get("/users/show.json?screen_name={$handle}")
            ->json();

        $name = trim(EmojiRemover::filter($data['name']));
        $avatar = Str::replace('_normal', '_200x200', $data['profile_image_url_https']);
        $url = Http::withOptions(['allow_redirects' => false])->get($data['url'])->header('location');
        $github = Str::match('/github.com\/(.*?)"/', Http::get($url)->body());
    }

    $person = Person::create([
        'name' => text('Full name', default: $name ?? '', required: true),
        'slug' => Str::slug($name),
        'x_handle' => $handle ?? null,
        'x_avatar_url' => $avatar ?? null,
        'github_handle' => text('GitHub handle', default: $github ?? ''),
        'website_url' => text('Website URL', default: $url ?? ''),
    ]);

    if ($groups = multiselect('Groups', Group::pluck('name', 'slug'))) {
        Group::findMany($groups)->each->addMember($person)->each->save();
    }
});

Artisan::command('person:groups', function () {
    $person = Person::find(search(
        label: 'Search for a person',
        options: fn (string $query) => Person::where('name', 'like', "%{$query}%")->orderBy('name')->pluck('name', 'slug')->all(),
    ));

    $groups = Group::all();

    $assigned = $groups->filter(fn ($group) => $group->members->contains($person->slug))->pluck('slug');

    $assigned = collect(multiselect(
        label: 'Groups',
        options: $groups->pluck('name', 'slug'),
        default: $assigned,
    ));

    $groups->each(function (Group $group) use ($assigned, $person) {
        $assigned->contains($group->slug)
            ? $group->addMember($person)
            : $group->removeMember($person);

        $group->save();
    });
});
