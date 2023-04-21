<?php

namespace App\Http\Resources;

use App\Http\Controllers\Dictionary\Dto\DictionaryDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin DictionaryDto
 */
class DictionaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->originWord->id,
            'value' => $this->originWord->value,
            'category' => $this->originWord->category_id,
            'translation' => new TranslationResource($this->translation),
        ];
    }
}
