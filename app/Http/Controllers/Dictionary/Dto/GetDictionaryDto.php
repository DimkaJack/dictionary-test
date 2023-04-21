<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dictionary\Dto;

use App\Constants\LocaleEnum;
use Illuminate\Http\Request;

final class GetDictionaryDto
{
    public function __construct(
        public readonly LocaleEnum $localeFrom,
        public readonly LocaleEnum $localeTo,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            localeFrom: LocaleEnum::from($request->input('localeFrom')),
            localeTo: LocaleEnum::from($request->input('localeTo')),
        );
    }
}
