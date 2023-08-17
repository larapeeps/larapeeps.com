<?php

declare(strict_types=1);

namespace App\Http\Controllers\Peeps;

use App\Models\Person;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class AvatarController
{
    public function __invoke(Request $request, string $slug)
    {
        // return the users avatar.
    }
}
