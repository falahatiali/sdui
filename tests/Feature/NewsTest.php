<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
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

    private User $user;

    private array $commonHeaders;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->commonHeaders = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /** @test */
    public function test_index(): void
    {
        News::factory(10)->create();

        $this->get('api/news', $this->commonHeaders)
            ->assertStatus(200)
            ->assertJsonStructure(self::JSON_COLLECTION_STRUCTURE);
    }

    /** @test */
    public function test_show_api_that_requires_authentication_token()
    {
        $news = News::factory()->create();

        $this->get('/api/news/' . $news->id, $this->commonHeaders)
            ->assertStatus(401);
    }

    /** @test */
    public function test_show_api_that_user_can_see_a_news()
    {
        $news = News::factory()->create();
        $this->actingAs($this->user);

        $this->get('/api/news/' . $news->id, $this->commonHeaders)
            ->assertStatus(200);
    }

    /** @test */
    public function test_news_store_api_validate_title_that_its_required()
    {
        $params = [
            'content' => fake()->sentence(12)
        ];
        $this->actingAs($this->user);

        $this->postJson('/api/news', $params, $this->commonHeaders)
            ->assertStatus(422)
            ->assertSeeText('The title field is required.');

    }

    /** @test */
    public function test_news_store_api_validate_title_that_it_should_have_at_least_10_words()
    {
        $params = [
            'title' => 'Hi',
            'content' => fake()->sentence(12)
        ];
        $this->actingAs($this->user);

        $this->postJson('/api/news', $params, $this->commonHeaders)
            ->assertStatus(422)
            ->assertSeeText('The title must be at least 10 characters.');
    }

    /** @test */
    public function test_news_store_api_validate_title_that_its_max_words_is_200()
    {
        $params = [
            'title' => fake()->sentence(201),
            'content' => fake()->sentence(12)
        ];
        $this->actingAs($this->user);

        $this->postJson('/api/news', $params, $this->commonHeaders)
            ->assertStatus(422)
            ->assertSeeText('The title must not be greater than 200 characters.');
    }

    /** @test */
    public function test_news_store_api_validate_content_that_its_required()
    {
        $params = [
            'title' => fake()->sentence(6),
        ];

        $this->actingAs($this->user);

        $this->postJson('/api/news', $params, $this->commonHeaders)
            ->assertStatus(422)
            ->assertSeeText('The content field is required.');
    }

    /** @test */
    public function test_news_store_api_validate_content_that_it_should_have_at_least_10_words()
    {
        $params = [
            'title' => fake()->sentence(12),
            'content' => 'Hi there'
        ];
        $this->actingAs($this->user);

        $this->postJson('/api/news', $params, $this->commonHeaders)
            ->assertStatus(422)
            ->assertSeeText('The content must be at least 10 characters.');
    }

    /** @test */
    public function test_create_news()
    {
        $params = [
            'title' => fake()->sentence(15),
            'content' => fake()->sentence(32)
        ];
        $this->actingAs($this->user);

        $this->postJson('/api/news', $params, $this->commonHeaders)
            ->assertStatus(201);

        self::assertDatabaseHas('news', $params);
        self::assertDatabaseCount('news', 1);
    }


}
