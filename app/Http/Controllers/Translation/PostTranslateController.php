<?php

namespace App\Http\Controllers\Translation;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Translation\Dto\PostTranslateDto;
use App\Http\Controllers\Translation\Request\PostTranslateRequest;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Builder;

class PostTranslateController extends Controller
{
    public function __construct() {
    }

    public function __invoke(PostTranslateRequest $request): Translation
    {
        // Обрабатываем запрос
        $dto = PostTranslateDto::fromRequest($request);
        // Получаем данные из БД
        $originWord = Translation::with('translations')
            ->where('value', $dto->word)
            ->whereHas('translations', function (Builder $query) use ($dto) {
                $query->where('locale', $dto->locale->value);
            })
            ->get();

        $translation = $originWord
            ->first()
            ->translations
            ->where('locale', $dto->locale->value)
            ->first();

        // без обработки, не успеваю
        return $translation;
    }
}
