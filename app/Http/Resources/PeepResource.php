<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Person;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

/**
 * @property-read Person $resource
 */
final class PeepResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->resource->name,
            'bio' => $this->resource->bio,
            'x' => [
                'handle' => $this->resource->x_handle,
                'avatar' => $this->resource->x_avatar_url,
            ],
            'github' => [
                'handle' => $this->resource->github_handle,
            ],
            'links' => [
                'website' => $this->resource->website_url,
            ]
        ];
    }
}
