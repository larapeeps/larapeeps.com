<?php

declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use TiMacDonald\JsonApi\JsonApiResource;

final class ResourceResponse implements Responsable
{
    public function __construct(
        private readonly JsonApiResource $data,
    ) {}

    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: $this->data,
            status: Response::HTTP_OK,
            headers: [
                'Content-Type' => 'application/larapeeps.api+json',
            ],
        );
    }
}
