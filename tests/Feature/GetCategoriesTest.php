<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function testSuccess(): void
    {
        $this->seed();

        $response = $this->get('/api/categories');

        $response
            ->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ]);
    }
}
