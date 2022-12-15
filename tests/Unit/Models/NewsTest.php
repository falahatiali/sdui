<?php

namespace Tests\Unit\Models;

use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class NewsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_schema_has_predefined_columns(): void
    {
        $this->assertEquals(
            1, Schema::hasColumns('news',
            ['id', 'title', 'content', 'created_at', 'updated_at'])
        );
    }

    /** @test  */
    public function test_a_user_has_many_news()
    {
        /** @var User $user */
        $user = User::factory()->create();

        News::factory(3, [
            'user_id' => $user->id
        ])->create();

        $this->assertEquals(3, $user->news()->count());
        $this->assertInstanceOf(News::class, $user->news->first());
    }

    /** @test  */
    public function test_a_news_belongs_to_user()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $news = News::factory([
            'user_id' => $user->id
        ])->create();

        $this->assertInstanceOf(User::class, $news->user);
    }
}
