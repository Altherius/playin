<?php

namespace App\Http\Schemas\PaginatedCollections;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'EventPaginatedCollection',
    properties: [
        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Event')),
    ],
    allOf: [new OA\Schema(ref: '#/components/schemas/PaginatedCollection')]
)]
abstract readonly class EventPaginatedCollection {}
