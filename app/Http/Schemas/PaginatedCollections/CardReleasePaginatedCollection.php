<?php

namespace App\Http\Schemas\PaginatedCollections;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CardReleasePaginatedCollection',
    properties: [
        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/CardRelease')),
    ],
    allOf: [new OA\Schema(ref: '#/components/schemas/PaginatedCollection')]
)]
abstract readonly class CardReleasePaginatedCollection {}
