<?php

namespace App\Console\Commands;

use App\Constants\LocaleEnum;
use App\Models\Category;
use App\Models\Translation;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class ImportDictionary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-dictionary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected array $words = [
        'pets' => [
            'parrot',
            'cat',
            'rabbit',
            'sibling',
        ],
        'sadness' => [
            'depression',
            'anxiety',
            'frustration',
            'panic',
        ],
    ];

    protected array $translationLocales = [
        LocaleEnum::EN->value => [
            LocaleEnum::RU->value,
            LocaleEnum::ES->value
        ],
    ];

    /**
     * Execute the console command.
     * @throws GuzzleException
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            foreach ($this->words as $categoryName => $words) {
                $category = $this->getCategory($categoryName);

                foreach ($words as $word) {

                    foreach ($this->translationLocales as $localeFrom => $localesTo) {
                        $originWord = $this->getOriginWord($word, $category);

                        foreach ($localesTo as $localeTo) {
                            // Если перевод уже есть, то пропускаем
                            $translation = Translation::where([
                                'locale' => $localeTo,
                                'group_id' => $originWord->group_id,
                            ])->first();
                            if ($translation) {
                                continue;
                            }

                            $client = new Client();
                            $request = new Request(
                                'GET',
                                "https://od-api.oxforddictionaries.com/api/v2/translations/$localeFrom/$localeTo/$word",
                                [
                                    'app_id' => '1e0f6373',
                                    'app_key' => '6da9adfd84b6b43a9024d0d58856373e',
                                ],
                            );
                            $response = $client->send($request);
                            $responseBody = json_decode($response->getBody()->getContents(), true);
                            Log::info('sdf', $responseBody);

                            $translationsResponse = Arr::get(
                                $responseBody,
                                'results.0.lexicalEntries.0.entries.0.senses.0.translations'
                            );
                            $translationResponse = collect($translationsResponse)->first();
                            if ($translationResponse === null) {
                                continue;
                            }
                            $translation = Translation::create([
                                'value' => $translationResponse['text'],
                                'locale' => $localeTo,
                                'category_id' => $category->id,
                                'group_id' => $originWord->group_id,
                            ]);

                            $exampleResponse = Arr::get(
                                $responseBody,
                                'results.0.lexicalEntries.0.entries.0.senses.0.examples'
                            );
                            collect($exampleResponse)->shift(3)->each(
                                fn($example) => $translation->examples()->create([
                                    'description' => $example['text'],
                                ])
                            );
//                            $this->info($responseBody[0]['word']);
                        }

//                        $translation
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function getCategory(string $categoryName): Category
    {
        $category = Category::where('name', $categoryName)->first();
        if ($category === null) {
            $category = Category::create([
                'name' => $categoryName,
            ]);
        }

        return $category;
    }

    private function getOriginWord(string $word, Category $category): Translation
    {
        $originWord = Translation::where([
            'value' => $word,
            'locale' => LocaleEnum::EN->value,
            'category_id' => $category->id,
        ])->first();

        if ($originWord === null) {
            $originWord = Translation::create([
                'value' => $word,
                'locale' => LocaleEnum::EN->value,
                'category_id' => $category->id,
                'group_id' => Uuid::uuid7(Carbon::now()),
            ]);
        }

        return $originWord;
    }
}
