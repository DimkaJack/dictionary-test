<?php


use App\Constants\LocaleEnum;
use App\Models\Translation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTranslateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function testSuccess(): void
    {
        $this->seed();

        $translation = Translation::where('locale', LocaleEnum::EN->value)->first();

        $response = $this->post('/api/translate', [
            'locale' => LocaleEnum::EN->value,
            'word' => $translation->value,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'category_id',
                'created_at',
                'updated_at',
                'group_id',
                'locale',
                'value',
                'examples' => [
                    '*' => [
                        'id',
                        'translation_id',
                        'created_at',
                        'updated_at',
                        'description',
                    ],
                ],
            ]);
    }
}
