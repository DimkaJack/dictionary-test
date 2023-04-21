<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetDictionaryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function testSuccess(): void
    {
        $this->seed();

        $response = $this->get('/api/dictionary?localeFrom=en&localeTo=ru');

        $response
            ->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'category',
                        'value',
                        'translation' => [
                            'id',
                            'value',
                            'examples' => [
                                '*' => [
                                    'id',
                                    'value',
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    }
}
