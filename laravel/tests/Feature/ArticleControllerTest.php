<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));

        $response->assertRedirect(route('login'));
    }
    use DatabaseTransactions;
    public function testAuthCreate()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('articles.create'));

        $response->assertStatus(200)
            ->assertViewIs('articles.create');
    }

    public function testGuestIndex()
    {
        $response = $this->get(route('articles.index'));

        $response->assertRedirect(route('login'));
    }

    use DatabaseTransactions;
    public function testAuthIndex()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('articles.index'));

        $response->assertStatus(200)
            ->assertViewIs('articles.index');
    }
    //投稿詳細機能
    use DatabaseTransactions;
    public function testGuestShow()
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create();
        $response = $this->get(route('articles.show', ['id' => $article->id]));

        $response->assertRedirect(route('login'));
    }
    use DatabaseTransactions;
    public function testAuthShow()
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create();
        $response = $this->actingAs($user)
            ->get(route('articles.show', ['id' => $article->id]));

        $response->assertStatus(200)->assertViewIs('articles.show');
    }
    //投稿編集機能
    use DatabaseTransactions;
    public function testGuestEdit()
    {
        $article = factory(Article::class)->create();
        $response = $this->get(route('articles.edit', ['id' => $article->id]));

        $response->assertRedirect(route('login'));
    }
    use DatabaseTransactions;
    public function testAuthEdit()
    {
        $article = factory(Article::class)->create();
        $user = $article->user;
        $response = $this->actingAs($user)
            ->get(route('articles.edit', ['id' => $article->id]));

        $response->assertStatus(200)->assertViewIs('articles.edit');
    }
}
