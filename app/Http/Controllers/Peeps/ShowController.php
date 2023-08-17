<?php

declare(strict_types=1);

namespace App\Http\Controllers\Peeps;

use App\Http\Resources\PeepResource;
use App\Http\Responses\ResourceResponse;
use App\Models\Person;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

final class ShowController
{
    public function __invoke(Request $request, string $slug): Responsable
    {
        return new ResourceResponse(
            data: new PeepResource(
                resource: Person::query()->where('slug', $slug)->firstOrFail(),
            ),
        );
    }
}
