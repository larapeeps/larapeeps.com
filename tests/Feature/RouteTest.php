<?php

use function Pest\Laravel\get;

test('homepage can be rendered')->get('/')->assertOk();

test('groups can be rendered', function ($slug) {
    get("/groups/{$slug}")->assertOk();
})->with([
    'bloggers',
    'core-team',
    'maintainers',
    'podcasters',
    'speakers',
    'youtubers',
]);
