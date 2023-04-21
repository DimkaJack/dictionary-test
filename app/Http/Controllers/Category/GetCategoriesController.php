<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dictionary\Dto\DictionaryDto;
use App\Http\Controllers\Dictionary\Dto\GetDictionaryDto;
use App\Http\Controllers\Dictionary\Request\GetDictionaryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\DictionaryResource;
use App\Models\Category;
use App\Models\Translation;

class GetCategoriesController extends Controller
{
    public function __construct() {
    }

    public function __invoke()
    {
        // Получаем данные из БД
        return CategoryResource::collection(Category::all());
    }
}
