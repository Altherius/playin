<?php

namespace App\Http\Resources;

use App\Enums\CardGrading;
use App\Enums\CardLanguage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property int $id
 * @property CardGrading $grading
 * @property CardLanguage $language
 */
#[OA\Schema(
    schema: 'CardPrintState',
    required: ['id', 'grading', 'language'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the boardgame properties', type: 'integer', nullable: false),
        new OA\Property(property: 'grading', description: 'The grading of the card', type: 'string', enum: [
            CardGrading::NMINT,
            CardGrading::EXCELLENT,
            CardGrading::PLAYED,
            CardGrading::POOR,
        ], nullable: false),
        new OA\Property(property: 'language', description: 'The language the card is printed in', type: 'string', enum: [
            CardLanguage::FRENCH,
            CardLanguage::ENGLISH,
            CardLanguage::GERMAN,
            CardLanguage::SPANISH,
            CardLanguage::PORTUGUESE,
            CardLanguage::ITALIAN,
            CardLanguage::RUSSIAN,
            CardLanguage::CHINESE_SIMPLIFIED,
            CardLanguage::CHINESE_TRADITIONAL,
            CardLanguage::JAPANESE,
            CardLanguage::KOREAN,
        ], nullable: false),
    ]
)]
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
