<?php

declare(strict_types=1);

use App\Models\Group;
use App\Models\Person;
use Arispati\EmojiRemover\EmojiRemover;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Squire\Models\Country;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
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
    $handle = text('Twitter handle', required: true);

    if (Person::where('x_handle', $handle)->exists()) {
        $this->components->error('Person already exists.');

        return;
    }

    if (null === config('services.twitter.token')) {
        $this->warn('Twitter API token not set. You can still add a person manually.');
    } else {
        $data = Http::withToken(config('services.twitter.token'))
            ->baseUrl('https://api.twitter.com/1.1')
            ->get("/users/show.json?screen_name={$handle}")
            ->json();

        $name = trim(EmojiRemover::filter($data['name']));
        $avatar = Str::replace('_normal', '_200x200', $data['profile_image_url_https']);
        $url = $data['url'] ? rescue(fn () => Http::withOptions(['allow_redirects' => false])->get($data['url'])->header('location')) : null;
        $github = $url ? rescue(fn () => Str::match('/github.com\/([a-z0-9\-]+)/', Http::get($url)->body())) : null;
        $location = $data['location'];
    }

    $person = Person::create([
        'name' => $name = text('Full name', default: $name ?? '', required: true),
        'slug' => Str::slug($name),
        'x_handle' => $handle ?? null,
        'x_avatar_url' => $avatar ?? null,
        'github_handle' => text('GitHub handle', default: $github ?? ''),
        'website_url' => text('Website URL', default: $url ?? ''),
        'country_code' => search(
            label: 'Country',
            hint: $location ?? '',
            options: function ($value) {
                $options = Country::where('name', 'like', "%{$value}%")->pluck('name', 'id');

                if (! $value) {
                    $options->prepend('-', null);
                }

                return $options->all();
            },
        ),
    ]);

    if ($groups = multiselect('Groups', Group::pluck('name', 'slug'))) {
        Group::findMany($groups)->each->addMember($person->slug)->each->save();
    }
});

Artisan::command('person:update', function () {
    $person = Person::findOrFail(search(
        label: 'Search for a person',
        options: fn (string $query) => Person::where('name', 'like', "%{$query}%")->orderBy('name')->pluck('name', 'slug')->all(),
    ));

    $person->name = text('Full name', default: $person->name, required: true);
    $person->slug = text('Slug', default: $person->slug, required: true);
    $person->x_handle = text('X handle', default: $person->x_handle ?? '');
    $person->github_handle = text('GitHub handle', default: $person->github_handle ?? '');
    $person->website_url = text('Website URL', default: $person->website_url ?? '');
    $person->country_code = search(
        label: 'Country',
        hint: $location ?? '',
        options: function ($value) {
            $options = Country::where('name', 'like', "%{$value}%")->pluck('name', 'id');

            if (! $value) {
                $options->prepend('-', null);
            }

            return $options->all();
        },
    );

    $groups = Group::all();

    $assigned = $groups->filter(fn ($group) => $group->members->contains($person->getOriginal('slug')))->pluck('slug');

    $assigned = collect(multiselect(
        label: 'Assign to groups',
        options: $groups->pluck('name', 'slug'),
        default: $assigned,
    ));

    $groups->each(function (Group $group) use ($assigned, $person) {
        $group->removeMember($person->getOriginal('slug'));

        $assigned->contains($group->slug)
            ? $group->addMember($person->slug)
            : $group->removeMember($person->slug);

        $group->save();
    });

    $person->save();
});
