<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_guest_user_cannot_create_a_json_post()
    {
        $excerpt = 'My first excerpt';
        $response = $this->postJson(route('api.posts.store'),['excerpt'=>$excerpt]);
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function a_registered_user_can_create_a_post()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $category =factory(Category::class)->create()->id;
        $tags = factory(Tag::class,2)->create()->pluck('id');

        $this->actingAs($user);
        $response = $this->postJson(route('api.posts.store'),$this->postData([
            'category' => $category,
            'tags' => $tags,
        ]));

        $this->assertDatabaseCount('posts',1);
        $this->assertDatabaseCount('post_tag',2);
        $this->assertDatabaseCount('tags',2);

        $response->assertStatus(200);

        $response->assertJson([
            'success'=>'The post has been successfully created'
        ]);
    }

    /**
     * @test
     */
    public function post_requires_all_fields()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->postJson(route('api.posts.store'),$this->postData([
            'title' => '',
            'excerpt' => '',
            'published_at' => '',
            'category_id' => ''
        ]));
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message','errors'=>['title','excerpt','published_at','category_id']
        ]);
    }

    /**
     * @test
     */
    public function post_requires_a_title_and_excerpt_minimum_length_5()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $response = $this->postJson(route('api.posts.store'),$this->postData([
            'title' => 'asdf',
            'excerpt' => 'asdf',
        ]));
        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message','errors'=>['title','excerpt']
        ]);
    }


    public function postData($overrides=[]):array
    {
        return array_merge([
            'title' => 'My Title',
            'excerpt' => 'My Excerpt',
            'published_at' => Carbon::yesterday()->toDateTimeString(),
            'category' => 1,
            'tag_id' => [1],
        ],$overrides);
    }
}
