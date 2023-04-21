<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dictionary\Dto;

use App\Constants\LocaleEnum;
use App\Models\Translation;
use Illuminate\Http\Request;
use Ramsey\Uuid\UuidInterface;

final class DictionaryDto
{
    public function __construct(
        public readonly Translation $originWord,
        public readonly ?Translation $translation,
    ) {
    }
}
