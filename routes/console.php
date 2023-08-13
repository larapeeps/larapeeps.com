<?php

use App\Models\Person;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Arispati\EmojiRemover\EmojiRemover;

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

Artisan::command('app:add-person {handle}', function ($handle) {
    $data = Http::withToken(config('services.twitter.token'))
        ->baseUrl('https://api.twitter.com/1.1')
        ->get("/users/show.json?screen_name={$handle}")
        ->json();

    Person::create([
        'name' => trim(EmojiRemover::filter($data['name'])),
        'slug' => Str::slug($data['name']),
        'bio' => $data['description'],
        'avatar_url' => $data['profile_image_url_https'],
        'x_handle' => $handle,
        'github_handle' => null,
    ]);
});
