<?php

namespace Tests\Feature;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsTest extends TestCase
{
    private const JSON_STRUCTURE = [
        'id',
        'title',
        'content',
        'user',
        'created_at',
    ];

    private const JSON_COLLECTION_STRUCTURE = [
        "data" => [
            '*' => self::JSON_STRUCTURE,
        ],
        "links" => [
            "first",
            "last",
            "prev",
            "next",
        ],
        "meta" => [
            "current_page",
            "path",
            "per_page",
            "to",
            "total",
        ]
    ];


    /** @test */
    public function test_index(): void
    {
        News::factory(10)->create();

        $this->get('api/news')
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_COLLECTION_STRUCTURE);
    }

    /** @test */
    public function test_show_api()
    {
        $news = News::factory()->create();

        $this->get('/api/news/' . $news->id)
            ->assertStatus(200);
    }
}
