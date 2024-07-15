<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property int $min_player_count
 * @property int $max_player_count
 * @property int $min_player_age
 * @property ?int $max_player_age
 * @property int $game_length_minutes
 */
#[OA\Schema(
    schema: 'BoardgameProperties',
    required: ['id', 'min_player_count', 'max_player_count', 'min_player_age', 'max_player_age', 'game_length_minutes'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the boardgame properties', type: 'integer', nullable: false),
        new OA\Property(property: 'min_player_count', description: 'The minimal number of players required to play', type: 'integer', minimum: 1, nullable: false),
        new OA\Property(property: 'max_player_count', description: 'The maximal number of players who can play simultaneously', type: 'integer', minimum: 1, nullable: false),
        new OA\Property(property: 'min_player_age', description: 'The required age to play the game', type: 'integer', minimum: 0, nullable: false),
        new OA\Property(property: 'max_player_age', description: 'The maximal age to play the game', type: 'integer', minimum: 0, nullable: true),
        new OA\Property(property: 'game_length_minutes', description: 'An estimation of a game length, in minutes', type: 'integer', minimum: 0, nullable: true),
    ]
)]
class BoardgamePropertiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'min_player_count' => $this->min_player_count,
            'max_player_count' => $this->max_player_count,
            'min_player_age' => $this->min_player_age,
            'max_player_age' => $this->max_player_age,
            'game_length_minutes' => $this->game_length_minutes,
        ];
    }
}
