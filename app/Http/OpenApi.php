<?php

namespace App\Http;

use OpenApi\Attributes as OA;

#[OA\Info(version: '0.5', title: 'Playin API')]
#[OA\Server(url: 'http://localhost', description: 'Local development environment')]
#[OA\Server(url: 'https://api-dev.play-in.com', description: 'Development environment')]
#[OA\Server(url: 'https://api-preprod.play-in.com', description: 'Staging environment')]
#[OA\Server(url: 'https://api.play-in.com', description: 'Production environment')]
final readonly class OpenApi {}
