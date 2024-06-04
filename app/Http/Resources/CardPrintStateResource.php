<?php

namespace App\Http\Resources;

use App\Enums\CardGrading;
use App\Enums\CardLanguage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property CardGrading $grading
 * @property CardLanguage $language
 */
class CardPrintStateResource extends JsonResource
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
            'grading' => $this->grading,
            'language' => $this->language,
        ];
    }
}
