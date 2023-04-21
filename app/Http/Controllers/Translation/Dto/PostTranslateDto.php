<?php

declare(strict_types=1);

namespace App\Http\Controllers\Translation\Dto;

use App\Constants\LocaleEnum;
use Illuminate\Http\Request;

final class PostTranslateDto
{
    public function __construct(
        public readonly LocaleEnum $locale,
        public readonly string $word,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            locale: LocaleEnum::from($request->input('locale')),
            word: $request->input('word'),
        );
    }
}
