<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Constants\LocaleEnum;
use App\Models\Category;
use App\Models\Translation;
use App\Models\TranslationExample;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = Category::factory(2)->create();
        $translations = [];
        foreach ($categories as $category) {
            $groupId = Uuid::uuid7(Carbon::now());
            foreach (LocaleEnum::cases() as $locale) {
                $translations[] = Translation::factory()->create([
                    'locale' => $locale->value,
                    'group_id' => $groupId,
                    'category_id' => $category->id,
                ]);
            }
        }
        foreach ($translations as $translation) {
            TranslationExample::factory(3)->create([
                'translation_id' => $translation->id,
            ]);
        }
    }
}
