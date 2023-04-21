<?php

namespace App\Http\Controllers\Dictionary;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dictionary\Dto\DictionaryDto;
use App\Http\Controllers\Dictionary\Dto\GetDictionaryDto;
use App\Http\Controllers\Dictionary\Request\GetDictionaryRequest;
use App\Http\Resources\DictionaryResource;
use App\Models\Translation;

class GetDictionaryController extends Controller
{
    public function __construct() {
    }

    public function __invoke(GetDictionaryRequest $request)
    {
        // Обрабатываем запрос
        $dto = GetDictionaryDto::fromRequest($request);
        // Получаем данные из БД
        $translations = Translation::with(['examples', 'category'])
            ->whereIn('locale', [$dto->localeFrom->value, $dto->localeTo->value])
            ->orderBy('category_id')
            ->orderBy('group_id')
            ->get();
        // Формируем dto для ответа
        $dictionary = $translations
            ->groupBy('group_id')
            ->map(fn($group) => new DictionaryDto(
                originWord: $group->where('locale', $dto->localeFrom->value)->first(),
                translation: $group->where('locale', $dto->localeTo->value)->first(),
            ))
            ->values();

        return DictionaryResource::collection($dictionary);
    }
}
