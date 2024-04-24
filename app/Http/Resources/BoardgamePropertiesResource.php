<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property int $min_player_count
 * @property int $max_player_count
 * @property int $min_player_age
 * @property ?int $max_player_age
 * @property int $game_length_minutes
 */
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
